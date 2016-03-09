<?php
namespace Commonhelp\ResourceLocator;

class RecursiveUniformResourceIterator extends UniformResourceIterator implements \RecursiveIterator{
	
	protected $subPath;
	
	public function getChildren(){
		$subPath = $this->getSubPathName();
		return (new RecursiveUniformResourceIterator($this->getUrl(), $this->flags, $this->locator))->setSubPath($subPath);
	}
	
	public function hasChildren($allow_links = false){
		return $this->iterator && $this->isDir() && !$this->isDot() && ($allow_links || !$this->isLink());
	}
	
	public function getSubPath(){
		return $this->subPath;
	}
	
	public function getSubPathName(){
		return ($this->subPath ? $this->subPath . '/' : '') . $this->getFilename();
	}
	
	/**
	 * @param $path
	 * @return $this
	 * @internal
	 */
	public function setSubPath($path){
		$this->subPath = $path;
		return $this;
	}
	
}