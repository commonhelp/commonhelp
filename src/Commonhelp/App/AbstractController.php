<?php
namespace Commonhelp\App;
use Commonhelp\App\Http\Request;
use Commonhelp\App\Http\RequestInterface;
use Commonhelp\App\Http\DataResponse;
use Commonhelp\App\Http\JsonResponse;
use Commonhelp\App\Http\Commonhelp\App\Http;
use Commonhelp\App\Exception\RenderException;

abstract class AbstractController{
	
	protected $appName;
	
	protected $request;
	
	protected $responders;

	protected $vars;
	
	public function __construct($appName, RequestInterface $request){
		$this->appName = $appName;
		$this->request = $request;
		$this->vars = array();
	}
	
	public function getAppName(){
		return $this->appName;
	}
	
	public function setAppName($app){
		$this->appName = $app;
	}
	
	/**
	 * Parses an HTTP accept header and returns the supported responder type
	 * @param string $acceptHeader
	 * @return string the responder type
	 */
	public function getResponderByHTTPHeader($acceptHeader) {
		$headers = explode(',', $acceptHeader);
		// return the first matching responder
		foreach ($headers as $header) {
			$header = strtolower(trim($header));
			$responder = str_replace('application/', '', $header);
			if (array_key_exists($responder, $this->responders)) {
				return $responder;
			}
		}
		// no matching header defaults to json
		return 'json';
	}
	
	public function registerResponder($responder, \Closure $closure){
		$this->responders[$responder] = $closure;
	}
	
	public function hasResponder($responder){
		return array_key_exists($responder, $this->responders);
	}
	
	public function render($response, $format = 'json'){
		if(array_key_exists($format, $this->responders)) {
			$responder = $this->responders[$format];
			return $responder($response);
		} else {
			throw new RenderException('No responder registered for format ' .
					$format . '!');
		}
	}
	
	public function assign($key, $value) {
		$this->vars[$key] = $value;
		return true;
	}
	
	public function getVars(){
		return $this->vars;
	}
	
	
	public function getParams() {
		return $this->request->getParams();
	}
	
	public function getParam($key, $default=null){
		return $this->request->getParam($key, $default);
	}
	
	public function method() {
		return $this->request->getMethod();
	}
	
	public function getUploadedFile($key) {
		return $this->request->getUploadedFile($key);
	}
	
	public function env($key) {
		return $this->request->getEnv($key);
	}
	
	public function cookie($key) {
		return $this->request->getCookie($key);
	}
	
}