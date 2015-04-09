<?php

namespace Commonhelp\Orm;

class PdoDataLayerTest extends \PHPUnit_Framework_TestCase{
	
	protected $connection = array(
		'dsn'			=> 'mysql:host=localhost;dbname=test;charset=UTF8',
		'username'		=> 'test',
		'password'		=> 'test'
	);
	
	public function testConnection(){
		$connection = PdoDataLayer::instance($this->connection);
		
		print_r($connection);
	}
	
}
	

