<?php
namespace Commonhelp\Asset\FileRegistry;

use Commonhelp\ResourceLocator\UniformResourceLocator;
use Symfony\Component\Finder\Finder;

abstract class FileRegistry implements FileRegistryInterface{
	
	protected $fileRegistry = array();
	
	/**
	 * 
	 * @var UniformResourceLocator
	 */
	protected $locator;
	
	/**
	 * 
	 * @var Finder
	 */
	protected $finder;
	
	/**
	 * 
	 * @param UniformResourceLocator $locator
	 */
	public function __construct(UniformResourceLocator $locator){
		$this->locator = $locator;
		$this->finder = new Finder();
	}
	
	public function get($handle){
		if(isset($this->fileRegistry[$handle])){
			return $this->fileRegistry[$handle];
		}
		
		return null;
	}
	
	public function all(){
		return $this->fileRegistry;
	}
	
	public function set($handle, $value){
		if(!isset($this->fileRegistry[$handle])){
			$this->fileRegistry[$handle] = $value;
		}
	}
	
	public function remove($handle){
		if(isset($this->fileRegistry[$handle])){
			unset($this->fileRegistry[$handle]);
		}
	}
	
	
	protected function convertName($handle){
		return preg_replace("/(\.)/", "-", $handle);
	}
	
}