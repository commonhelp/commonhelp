<?php

namespace Commonhelp\Orm;

use Commonhelp\Orm\Exception\DataMapperException;
use Commonhelp\Util\Inflector;
abstract class PdoDataMapper implements Mapper{
	
	protected $layer;
	protected $locator;
	protected $entityName;
	
	protected $queryManager;
	
	public function __construct(PdoDataLayer $layer, $entityName=null){
		$this->layer = $layer;
		if(!is_null($entityName)){
			$this->entityName = $entityName;
		}else{
			$this->entityName = str_replace('Mapper', '', get_class($this));
		} 
	}
	
	public function __call($name, $arguments){
		if(preg_match("/\A(find|create|update|read)(All|By){0,1}(By|[A-Za-z]+){0,1}([A-Za-z]+){0,1}/", $name, $match) 
				&& $this->layer instanceof PdoDataLayer){
			$method = $match[1];
			if(isset($match[2]) && Inflector::underscore($match[2]) != "by"){
				$arguments = array_merge($arguments, array(strtolower($match[2])));
			}
			if(isset($match[3]) && Inflector::underscore($match[3]) != "by"){
				$arguments = array_merge($arguments, array(Inflector::underscore($match[3])));
			}
			if(isset($match[4]) && Inflector::underscore($match[4]) != "by"){
				$arguments = array_merge($arguments, array(Inflector::underscore($match[4])));
			}
			return call_user_func_array(array($this, $method), $arguments);
		}else{
			throw new DataMapperException("Invalid method call");
		}
	}
	
	public function getVisitor(){
		return $this->layer->getVisitor();
	}
	
	public function create(){
		$args = $this->parseArgs(func_get_args());
	}
	
	public function find(){
		$args = $this->parseArgs(func_get_args());
	}
	
	public function read(){
		return $this->find(func_get_args());
	}
	
	public function update(){
		$args = $this->parseArgs(func_get_args());
	}
	
	public function delete(){
		$args = $this->parseArgs(func_get_args());
	}
	
}

