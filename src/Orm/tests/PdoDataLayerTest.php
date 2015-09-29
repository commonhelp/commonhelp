<?php

namespace Commonhelp\Orm;

use Commonhelp\Orm\Sql\Sql;
use Commonhelp\DI\Container;
use Commonhelp\Config\ConfigServiceProvider;
class PdoDataLayerTest extends \PHPUnit_Framework_TestCase{
	
	protected $config;
	protected $layer;
	
	protected $connection = array(
		'dsn'			=> 'mysql:host=localhost;dbname=test;charset=UTF8',
		'username'		=> 'test',
		'password'		=> 'test'
	);
	
	public function __construct(){
		$this->layer = new PdoDataLayer($this->connection);
	}
	
	public function testConnection(){
		$connection = PdoDataLayer::instance($this->connection);
	}
	
	/*public function testRead(){
		$locator = new Locator($this->layer);
		$mapper = $locator->mapper('Entity\User');
		$users = Sql::table('users');
		$select = $users->project('*');
		$select->engine($mapper);
		print_r($this->layer->read($select));
		
		$this->layer->close();
	}
	
	public function testMapper(){
		$locator = new Locator($this->layer);
		$mapper = $locator->mapper('Entity\User');
		$users = $mapper->findById();
		$users = $mapper->findAll();
		$users = $mapper->findAllByUserName();
	}*/
	
}