<?php

namespace Commonhelp\Orm;

abstract class Mapper{
	
	protected $layer;
	
	public function __construct(DataLayerInterface $layer){
		$this->layer = $layer;
	}
	
	public function getVisitor(){
		return $this->layer->getVisitor();
	}
}

