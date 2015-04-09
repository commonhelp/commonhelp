<?php

namespace Commonhelp\Orm;

abstract class Mapper{
	
	protected $layer;
	
	public function __construct(DataLayerInterface $layer){
		$this->layer = $layer;
	}
	
	public abstract function create();
	public abstract function read();
	public abstract function update();
	public abstract function delete();
	
	
	public function getVisitor(){
		return $this->layer->getVisitor();
	}
}

