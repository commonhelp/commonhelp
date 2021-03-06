<?php

namespace Commonhelp\Client;

use Commonhelp\Client\Exception\ClientException;
use Commonhelp\Client\Exception\MaxRedirectException;
use Commonhelp\Client\Exception\InvalidCertificateException;
use Commonhelp\Client\Exception\InvalidUrlException;
use Commonhelp\Client\Exception\MaxSizeException;
use Commonhelp\Client\Exception\TimeoutException;

/**
 * cURL HTTP client.
 *
 * @author  Frederic Guillot
 */
class Curl extends Client{
    /**
     * HTTP response body.
     *
     * @var string
     */
    private $body = '';

    /**
     * Body size.
     *
     * @var int
     */
    private $bodyLength = 0;

    /**
     * HTTP response headers.
     *
     * @var array
     */
    private $responseHeaders = array();

    /**
     * Counter on the number of header received.
     *
     * @var int
     */
    private $responseHeadersCount = 0;

    /**
     * cURL callback to read the HTTP body.
     *
     * If the function return -1, curl stop to read the HTTP response
     *
     * @param resource $ch     cURL handler
     * @param string   $buffer Chunk of data
     *
     * @return int Length of the buffer
     */
    public function readBody($ch, $buffer){
        $length = strlen($buffer);
        $this->bodyLength += $length;

        if ($this->bodyLength > $this->maxBodySize) {
            return -1;
        }

        $this->body .= $buffer;

        return $length;
    }

    /**
     * cURL callback to read HTTP headers.
     *
     * @param resource $ch     cURL handler
     * @param string   $buffer Header line
     *
     * @return int Length of the buffer
     */
    public function readHeaders($ch, $buffer){
        $length = strlen($buffer);

        if ($buffer === "\r\n" || $buffer === "\n") {
            ++$this->responseHeadersCount;
        } else {
            if (!isset($this->responseHeaders[$this->responseHeadersCount])) {
                $this->responseHeaders[$this->responseHeadersCount] = '';
            }

            $this->responseHeaders[$this->responseHeadersCount] .= $buffer;
        }

        return $length;
    }

    /**
     * cURL callback to passthrough the HTTP status header to the client.
     *
     * @param resource $ch     cURL handler
     * @param string   $buffer Header line
     *
     * @return int Length of the buffer
     */
    public function passthroughHeaders($ch, $buffer)
    {
        list($status, $headers) = HttpHeaders::parse(array($buffer));

        if ($status !== 0) {
            header(':', true, $status);
        } elseif (isset($headers['Content-Type'])) {
            header($buffer);
        }

        return $this->readHeaders($ch, $buffer);
    }

    /**
     * cURL callback to passthrough the HTTP body to the client.
     *
     * If the function return -1, curl stop to read the HTTP response
     *
     * @param resource $ch     cURL handler
     * @param string   $buffer Chunk of data
     *
     * @return int Length of the buffer
     */
    public function passthroughBody($ch, $buffer){
        echo $buffer;

        return strlen($buffer);
    }

    /**
     * Prepare HTTP headers.
     *
     * @return string[]
     */
    private function prepareHeaders(){
        $headers = array(
            'Connection: close',
        );

        if ($this->etag) {
            $headers[] = 'If-None-Match: '.$this->etag;
        }

        if ($this->lastModified) {
            $headers[] = 'If-Modified-Since: '.$this->lastModified;
        }

        $headers = array_merge($headers, $this->requestHeaders);

        return $headers;
    }

    /**
     * Prepare curl proxy context.
     *
     * @param resource $ch
     *
     * @return resource $ch
     */
    private function prepareProxyContext($ch){
        if ($this->proxyHostname) {
            curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxyPort);
            curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($ch, CURLOPT_PROXY, $this->proxyHostname);

            if ($this->proxyUsername) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyUsername.':'.$this->proxyPassword);
            }
        }

        return $ch;
    }

    /**
     * Prepare curl auth context.
     *
     * @param resource $ch
     *
     * @return resource $ch
     */
    private function prepareAuthContext($ch){
        if ($this->username && $this->password) {
            curl_setopt($ch, CURLOPT_USERPWD, $this->username.':'.$this->password);
        }

        return $ch;
    }

    /**
     * Set write/header functions.
     *
     * @param resource $ch
     *
     * @return resource $ch
     */
    private function prepareDownloadMode($ch){
        $writeFunction = 'readBody';
        $headerFunction = 'readHeaders';

        if ($this->isPassthroughEnabled()) {
            $writeFunction = 'passthroughBody';
            $headerFunction = 'passthroughHeaders';
        }

        curl_setopt($ch, CURLOPT_WRITEFUNCTION, array($this, $writeFunction));
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, $headerFunction));

        return $ch;
    }

    /**
     * Prepare curl context.
     *
     * @return resource
     */
    private function prepareContext(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->prepareHeaders());
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'php://memory');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'php://memory');

        // Disable SSLv3 by enforcing TLSv1.x for curl >= 7.34.0 and < 7.39.0.
        // Versions prior to 7.34 and at least when compiled against openssl
        // interpret this parameter as "limit to TLSv1.0" which fails for sites
        // which enforce TLS 1.1+.
        // Starting with curl 7.39.0 SSLv3 is disabled by default.
        $version = curl_version();
        if ($version['version_number'] >= 467456 && $version['version_number'] < 468736) {
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        }

        $ch = $this->prepareDownloadMode($ch);
        $ch = $this->prepareProxyContext($ch);
        $ch = $this->prepareAuthContext($ch);

        return $ch;
    }

    /**
     * Execute curl context.
     */
    private function executeContext(){
        $ch = $this->prepareContext();
        curl_exec($ch);

        $curl_errno = curl_errno($ch);

        if ($curl_errno) {
            curl_close($ch);
            $this->handleError($curl_errno);
        }

        // Update the url if there where redirects
        $this->url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        curl_close($ch);
    }

    /**
     * Do the HTTP request.
     *
     * @param bool $follow_location Flag used when there is an open_basedir restriction
     *
     * @return array HTTP response ['body' => ..., 'status' => ..., 'headers' => ...]
     */
    public function doRequest($follow_location = true){
        $this->executeContext();

        list($status, $headers) = HttpHeaders::parse(explode("\n", $this->responseHeaders[$this->responseHeadersCount - 1]));

        if ($follow_location && ($status == 301 || $status == 302)) {
            return $this->handleRedirection($headers['Location']);
        }

        return array(
            'status' => $status,
            'body' => $this->body,
            'headers' => $headers,
        );
    }

    /**
     * Handle manually redirections when there is an open base dir restriction.
     *
     * @param string $location Redirected URL
     *
     * @return array
     */
    private function handleRedirection($location){
        $nb_redirects = 0;
        $result = array();
        $this->url = Url::resolve($location, $this->url);
        $this->body = '';
        $this->bodyLength = 0;
        $this->responseHeaders = array();
        $this->responseHeadersCount = 0;

        while (true) {
            ++$nb_redirects;

            if ($nb_redirects >= $this->maxRedirects) {
                throw new MaxRedirectException('Maximum number of redirections reached');
            }

            $result = $this->doRequest(false);

            if ($result['status'] == 301 || $result['status'] == 302) {
                $this->url = Url::resolve($result['headers']['Location'], $this->url);
                $this->body = '';
                $this->bodyLength = 0;
                $this->responseHeaders = array();
                $this->responseHeadersCount = 0;
            } else {
                break;
            }
        }

        return $result;
    }

    /**
     * Handle cURL errors (throw individual exceptions).
     *
     * We don't use constants because they are not necessary always available
     * (depends of the version of libcurl linked to php)
     *
     * @see    http://curl.haxx.se/libcurl/c/libcurl-errors.html
     *
     * @param int $errno cURL error code
     */
    private function handleError($errno){
        switch ($errno) {
            case 78: // CURLE_REMOTE_FILE_NOT_FOUND
                throw new InvalidUrlException('Resource not found');
            case 6:  // CURLE_COULDNT_RESOLVE_HOST
                throw new InvalidUrlException('Unable to resolve hostname');
            case 7:  // CURLE_COULDNT_CONNECT
                throw new InvalidUrlException('Unable to connect to the remote host');
            case 23: // CURLE_WRITE_ERROR
                throw new MaxSizeException('Maximum response size exceeded');
            case 28: // CURLE_OPERATION_TIMEDOUT
                throw new TimeoutException('Operation timeout');
            case 35: // CURLE_SSL_CONNECT_ERROR
            case 51: // CURLE_PEER_FAILED_VERIFICATION
            case 58: // CURLE_SSL_CERTPROBLEM
            case 60: // CURLE_SSL_CACERT
            case 59: // CURLE_SSL_CIPHER
            case 64: // CURLE_USE_SSL_FAILED
            case 66: // CURLE_SSL_ENGINE_INITFAILED
            case 77: // CURLE_SSL_CACERT_BADFILE
            case 83: // CURLE_SSL_ISSUER_ERROR
                throw new InvalidCertificateException('Invalid SSL certificate');
            case 47: // CURLE_TOO_MANY_REDIRECTS
                throw new MaxRedirectException('Maximum number of redirections reached');
            case 63: // CURLE_FILESIZE_EXCEEDED
                throw new MaxSizeException('Maximum response size exceeded');
            default:
                throw new InvalidUrlException('Unable to fetch the URL');
        }
    }
}