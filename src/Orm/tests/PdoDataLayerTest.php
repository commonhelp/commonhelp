<?php

namespace Commonhelp\Orm;

use Commonhelp\Orm\Sql\Sql;
class PdoDataLayerTest extends \PHPUnit_Framework_TestCase{
	
	protected $connection = array(
		'dsn'			=> 'mysql:host=localhost;dbname=test;charset=UTF8',
		'username'		=> 'test',
		'password'		=> 'test'
	);
	
	public function testConnection(){
		$connection = PdoDataLayer::instance($this->connection);
	}
	
	public function testRead(){
		$layer = new PdoDataLayer($this->connection);
		$engine = new User($layer);
		$users = Sql::table('users');
		$select = $users->project('*');
		$select->engine($engine);
		//print_r($layer->read($select));
		
		$layer->close();
	}
	
	public function testActiveRecord(){
		$user = User::findAll();
	}
	
}