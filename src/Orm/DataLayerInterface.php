<?php

namespace Commonhelp\Orm;

abstract class DataLayerInterface{
	protected static $instance = false;
	protected $visitor;
	
	public static function instance(array $options){
		if(!static::$instance){
			static::$instance = new LdapDataLayer($options);
		}
		
		return static::$instance;
	}
	
	public function getVisitor(){
		return $this->visitor;
	}
	
}

