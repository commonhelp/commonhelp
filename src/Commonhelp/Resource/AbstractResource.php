<?php
namespace Commonhelp\Resource;


abstract class AbstractResource implements Resource{
	
	protected $resource;
	protected $auth;
	
	public function getResource(){
		if(!is_resource($this->resource)){
			$this->createResource();
		}
		
		return $this->resource;
	}
	
	protected abstract function createResource();
	
	protected function auth(){
		return $this->auth->authenticate($this->resource);
	}
	
}

?>