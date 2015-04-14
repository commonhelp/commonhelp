<?php

namespace Commonhelp\Orm;

use Commonhelp\Orm\Exception\ActiveRecordException;

abstract class ActiveRecord extends Mapper{
	
	public static function __callStatic($name, $arguments){
		if(preg_match("/\A(find|create|update|read)([A-Z]{1}[a-z]+)/", $name, $match)){
			$method = $match[1];
			$arguments = array_merge($arguments, array(strtolower($match[2])));
			return call_user_func_array(array('static', "static::{$method}"), $arguments);
		}else{
			throw new ActiveRecordException('Invalid method call');
		}
	}
	
	public static function find(){
		print_r(func_get_args());
	}
	
	public static function read(){
	}
	
	public static function create(){
	}
	
	public static function update(){
	}
	
}