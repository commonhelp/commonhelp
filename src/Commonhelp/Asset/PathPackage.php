<?php
namespace Commonhelp\Asset;

use Commonhelp\Asset\VersionStrategy\VersionStrategyInterface;
use Commonhelp\Asset\Context\ContextInterface;
class PathPackage extends Package{
	
	private $basePath;
	
	public function __construct($basePath, VersionStrategyInterface $versionStrategy, ContextInterface $context = null){
		parent::__construct($versionStrategy, $context);
		
		if(!$basePath){
			$this->basePath = '/';
		}else{
			if('/' != $basePath[0]){
				$basePath = '/' . $basePath;
			}
			
			$this->basePath = rtrim($basePath, '/') . '/';
		}
	}
	
	public function getUrl($path){
		if($this->isAbsoluteUrl($path)){
			return $path;
		}
		
		return $this->getBasePath() . ltrim($this->getVersionStrategy()->applyVersion($path), '/');
	}
	
	public function getBasePath(){
		return $this->getContext()->getBasePath() . $this->basePath;
	}
	
}