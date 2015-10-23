<?php
namespace Commonhelp\Rss;

use Commonhelp\Config\Config;
/**
* @method  \PicoFeed\Config\Config setClientTimeout(integer $value)
* @method  \PicoFeed\Config\Config setClientUserAgent(string $value)
* @method  \PicoFeed\Config\Config setMaxRedirections(integer $value)
* @method  \PicoFeed\Config\Config setMaxBodySize(integer $value)
* @method  \PicoFeed\Config\Config setProxyHostname(string $value)
* @method  \PicoFeed\Config\Config setProxyPort(integer $value)
* @method  \PicoFeed\Config\Config setProxyUsername(string $value)
* @method  \PicoFeed\Config\Config setProxyPassword(string $value)
* @method  \PicoFeed\Config\Config setGrabberRulesFolder(string $value)
* @method  \PicoFeed\Config\Config setGrabberTimeout(integer $value)
* @method  \PicoFeed\Config\Config setGrabberUserAgent(string $value)
* @method  \PicoFeed\Config\Config setParserHashAlgo(string $value)
* @method  \PicoFeed\Config\Config setContentFiltering(boolean $value)
* @method  \PicoFeed\Config\Config setTimezone(string $value)
* @method  \PicoFeed\Config\Config setFilterIframeWhitelist(array $value)
* @method  \PicoFeed\Config\Config setFilterIntegerAttributes(array $value)
* @method  \PicoFeed\Config\Config setFilterAttributeOverrides(array $value)
* @method  \PicoFeed\Config\Config setFilterRequiredAttributes(array $value)
* @method  \PicoFeed\Config\Config setFilterMediaBlacklist(array $value)
* @method  \PicoFeed\Config\Config setFilterMediaAttributes(array $value)
* @method  \PicoFeed\Config\Config setFilterSchemeWhitelist(array $value)
* @method  \PicoFeed\Config\Config setFilterWhitelistedTags(array $value)
* @method  \PicoFeed\Config\Config setFilterBlacklistedTags(array $value)
* @method  \PicoFeed\Config\Config setFilterImageProxyUrl($value)
* @method  \PicoFeed\Config\Config setFilterImageProxyCallback($closure)
* @method  \PicoFeed\Config\Config setFilterImageProxyProtocol($value)
* @method  integer    getClientTimeout()
* @method  string     getClientUserAgent()
* @method  integer    getMaxRedirections()
* @method  integer    getMaxBodySize()
* @method  string     getProxyHostname()
* @method  integer    getProxyPort()
* @method  string     getProxyUsername()
* @method  string     getProxyPassword()
* @method  string     getGrabberRulesFolder()
* @method  integer    getGrabberTimeout()
* @method  string     getGrabberUserAgent()
* @method  string     getParserHashAlgo()
* @method  boolean    getContentFiltering(bool $default_value)
* @method  string     getTimezone()
* @method  array      getFilterIframeWhitelist(array $default_value)
* @method  array      getFilterIntegerAttributes(array $default_value)
* @method  array      getFilterAttributeOverrides(array $default_value)
* @method  array      getFilterRequiredAttributes(array $default_value)
* @method  array      getFilterMediaBlacklist(array $default_value)
* @method  array      getFilterMediaAttributes(array $default_value)
* @method  array      getFilterSchemeWhitelist(array $default_value)
* @method  array      getFilterWhitelistedTags(array $default_value)
* @method  array      getFilterBlacklistedTags(array $default_value)
* @method  string     getFilterImageProxyUrl()
* @method  \Closure   getFilterImageProxyCallback()
* @method  string     getFilterImageProxyProtocol()
*/
class RssConfig extends Config{
	
	protected $validMethodList = array(
		'setClientTimeout',
		'setClientUserAgent',
		'setMaxRedirections',
		'setMaxBodySize',
		'setProxyHostname',
		'setProxyPort',
		'setProxyUsername',
		'setProxyPassword',
		'setGrabberRulesFolder',
		'setGrabberTimeout',
		'setGrabberUserAgent',
		'setParserHashAlgo',
		'setContentFiltering',
		'setTimezone',
		'setFilterIframeWhitelist',
		'setFilterIntegerAttributes',
		'setFilterAttributeOverrides',
		'setFilterRequiredAttributes',
		'setFilterMediaBlacklist',
		'setFilterMediaAttributes',
		'setFilterSchemeWhitelist',
		'setFilterWhitelistedTags',
		'setFilterBlacklistedTags',
		'setFilterImageProxyUrl',
		'setFilterImageProxyCallback',
		'setFilterImageProxyProtocol',
		'getClientTimeout',
		'getClientUserAgent',
		'getMaxRedirections',
		'getMaxBodySize',
		'getProxyHostname',
		'getProxyPort',
		'getProxyUsername',
		'getProxyPassword',
		'getGrabberRulesFolder',
		'getGrabberTimeout',
		'getGrabberUserAgent',
		'getParserHashAlgo',
		'getContentFiltering',
		'getTimezone',
		'getFilterIframeWhitelist',
		'getFilterIntegerAttributes',
		'getFilterAttributeOverrides',
		'getFilterRequiredAttributes',
		'getFilterMediaBlacklist',
		'getFilterMediaAttributes',
		'getFilterSchemeWhitelist',
		'getFilterWhitelistedTags',
		'getFilterBlacklistedTags',
		'getFilterImageProxyUrl',
		'getFilterImageProxyCallback',
		'getFilterImageProxyProtocol'
	);
	
	public function isValidMethod($method){
		return in_array($method, $this->validMethodList);
	}
	
}