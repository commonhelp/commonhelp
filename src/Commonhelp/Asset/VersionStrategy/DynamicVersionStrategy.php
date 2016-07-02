<?php
namespace Commonhelp\Asset\VersionStrategy;

class DynamicVersionStrategy implements VersionStrategyInterface{
	
	private $version;
	
	public function __construct(){
	}
	
	public function getVersion($path){
		return $this->version;
	}
	
	public function setVersion($version){
		$this->version = $version;
	}
	
	public function applyVersion($path){
		return sprintf('%s?ver=%s', $path, $this->getVersion($path));
	}
	
}