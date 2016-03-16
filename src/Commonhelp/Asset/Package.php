<?php
namespace Commonhelp\Asset;

use Commonhelp\Asset\VersionStrategy\VersionStrategyInterface;
use Commonhelp\Asset\Context\ContextInterface;
use Commonhelp\Asset\Context\NullContext;

class Package implements PackageInterface{
	
	private $versionStrategy;
	private $context;
	
	/**
	 * 
	 * @param VersionStrategyInterface $versionStrategy
	 * @param ContextInterface $context
	 */
	public function __construct(VersionStrategyInterface $versionStrategy, ContextInterface $context = null){
		$this->versionStrategy = $versionStrategy;
		$this->context = $context ?: new NullContext();
	}
	
	public function getVersion($path){
		return $this->versionStrategy->getVersion($path);
	}
	
	public function getUrl($path){
		if($this->isAbsoluteUrl($path)){
			return $path;
		}
		
		return $this->versionStrategy->applyVersion($path);
	}
	
	public function setVersionStrategy(VersionStrategyInterface $versionStrategy){
		$this->versionStrategy = $versionStrategy;
	}
	
	protected function getContext(){
		return $this->context;
	}
	
	public function getVersionStrategy(){
		return $this->versionStrategy;
	}
	
	protected function isAbsoluteUrl($url){
		return false !== strpos($url, '://') || '//' === substr($url, 0, 2);
	}
	
}