<?php
namespace Commonhelp\Asset\VersionStrategy;

class StaticVersionStrategy implements VersionStrategyInterface{
	
	private $version;
	private $format;
	
	public function __construct($version, $format=null){
		$this->version = $version;
		$this->format = $format ?: '%s?%s';
	}
	
	public function getVersion($path){
		return $this->version;
	}
	
	public function setVersion($version){
		$this->version = $version;
	}
	
	public function applyVersion($path){
		$versionized = sprintf($this->format, ltrim($path, '/'), $this->getVersion($path));
		
		if ($path && '/' == $path[0]) {
			return '/'.$versionized;
		}
		
		return $versionized;
	}
	
}