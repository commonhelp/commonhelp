<?php

namespace Commonhelp\Orm;

use Commonhelp\Util\Expression\AstManager;

abstract class DataLayerInterface{
	protected static $instance = false;
	protected $visitor;
	protected $lastQuery;
	
	public static function instance(array $options){
		if(!static::$instance){
			static::$instance = new static($options);
		}
		
		return static::$instance;
	}
	
	public function getVisitor(){
		return $this->visitor;
	}
	
	
	public abstract function connect();
	public abstract function read(AstManager $manager);
	public abstract function write(AstManager $manager);
	public abstract function close();
}