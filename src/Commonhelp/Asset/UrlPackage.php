<?php
namespace Commonhelp\Asset;

use Commonhelp\Asset\VersionStrategy\VersionStrategyInterface;
use Commonhelp\Asset\Context\ContextInterface;

class UrlPackage extends Package{
	
	private $baseUrls = array();
	private $sslPackage;
	
	public function __construct($baseUrls, VersionStrategyInterface $versionStrategy, ContextInterface $context = null){
		parent::__construct($versionStrategy, $context);
		
		if(!is_array($baseUrls)){
			$baseUrls = (array) $baseUrls;
		}
		
		if(!$baseUrls){
			throw new \LogicException('You must provide at least one base URL.');
		}
		
		foreach($baseUrls as $baseUrl){
			$this->baseUrls[] = rtrim($baseUrl, '/');
		}
		
		$sslUrls = $this->getSeelUrls($baseUrls);
		
		if($sslUrls && $baseUrls !== $sslUrls){
			$this->sslPackage = new self($sslUrls, $versionStrategy);
		}
		
	}
	
	public function getUrl($path){
		if($this->isAbsoluteUrl($path)){
			return $path;
		}
		
		if(null !== $this->sslPackage && $this->getContext()->isSecure()){
			return $this->sslPackage->getUrl($path);
		}
		
		$url = $this->getVersionStrategy()->applyVersion($path);
		
		if($url && '/' != $url[0]){
			$url = '/' . $url;
		}
		
		return $this->getBaseUrl($path) . $url;
	}
	
	public function getBaseUrl($path){
		if(1 === count($this->baseUrls)){
			return $this->baseUrls[0];
		}
		
		return $this->baseUrls[$this->chooseBaseUrl($path)];
	}
	
	protected function chooseBaseUrl($path){
		return (int) fmod(hexdec(substr(hash('sha256', $path), 0, 10)), count($this->baseUrls));
	}
	
	
	private function getSeelUrls($urls){
		$sslUrls = array();
		foreach($urls as $url){
			if('https://' === substr($url, 0, 8) || '//' === substr($url, 0, 2)){
				$sslUrls[] = $url;
			}else if('http://' !== substr($url, 0, 7)){
				throw new \InvalidArgumentException(sprintf('"%s" is not a valid URL', $url));
			}
		}
		
		return $sslUrls;
	}
	
}