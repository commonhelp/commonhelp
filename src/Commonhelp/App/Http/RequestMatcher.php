<?php
namespace Commonhelp\App\Http;

class RequestMatcher{
	
	private $path;
	
	private $host;
	
	private $methods = array();
	
	private $ips = array();
	
	private $attributes = array();
	
	private $schemes = array();
	
	/**
	 * 
	 * @param string $path
	 * @param string $host
	 * @param string $methods
	 * @param string $ips
	 * @param array $attributes
	 * @param string $schemes
	 */
	public function __construct($path = null, $host = null, $methods = null, $ips = null, array $attributes = array(), $schemes = null){
		$this->matchPath($path);
		$this->matchHost($host);
		$this->matchMethod($methods);
		$this->matchIps($ips);
		$this->matchScheme($schemes);
		
		foreach($attributes as $k => $v){
			$this->matchAttribute($key, $v);
		}
	}
	
	/**
	 * 
	 * @param string|string[]|null $scheme
	 */
	public function matchScheme($scheme){
		$this->schemes = array_map('strtolower', (array) $scheme);
	}
	
	/**
	 * 
	 * @param string $regexp
	 */
	public function matchHost($regexp){
		$this->host = $regexp;
	}
	
	/**
	 * 
	 * @param string $regexp
	 */
	public function matchPath($regexp){
		$this->path = $regexp;
	}
	
	/**
	 * 
	 * @param string $ip
	 */
	public function matchIp($ip){
		$this->matchIps($ip);
	}
	
	/**
	 * 
	 * @param string|string[] $ips
	 */
	public function matchIps($ips){
		$this->ips = (array) $ips;
	}
	
	/**
	 * 
	 * @param string|string[] $method
	 */
	public function matchMethod($method){
		$this->methods = array_map('strtoupper', (array) $method);
	}
	
	/**
	 * 
	 * @param string $key
	 * @param string $regexp
	 */
	public function matchAttribute($key, $regexp){
		$this->attributes[$key] = $regexp;
	}
	
	/**
	 * @param Request $request
	 */
	public function matches(Request $request){
		if($this->schemes && !in_array($request->getScheme(), $this->schemes)){
			return false;
		}
		
		if($this->methods && !in_array($request->getMethod(), $this->methods)){
			return false;
		}
		
		foreach($this->attributes as $key => $pattern){
			if(!preg_match('{' . $pattern . '}', $request->getParam($key))){
				return false;
			}
		}
		
		if(null !== $this->path && !preg_match('{' . $this->path . '}', rawurldecode($request->getPathInfo()))){
			return false;
		}
		
		if(null !== $this->host && !preg_match('{' . $this->host . '}', $request->getHost())){
			return false;
		}
		
		/** TODO CHECK CLIENT IP */
		
		return true;
	}
	
}