<?php
namespace Commonhelp\Asset\Dependencies;

final class Dependency{
	
	private $handle;
	
	private $dependencies = array();
	
	private $version = null;
	
	public function __construct($handle, array $dependencies = array(), $version = null){
		$this->handle = $handle;
		$this->dependencies = $dependencies;
		$this->version = $version;
	}
	
	public function getHandle(){
		return $this->handle;
	}
	
	public function getVersion(){
		return $this->version;
	}
	
	public function get($depencency){
		if(($key = array_search($depencency, $this->dependencies)) !== false){
			return $this->dependencies[$key];
		}
		
		return null;
	}
	
	public function all(){
		return $this->dependencies;
	}
	
	public function set($dependency){
		if(($key = array_search($depencency, $this->dependencies)) !== false){
			return null;
		}
		
		$this->dependencies[] = $dependency;
	}
	
}