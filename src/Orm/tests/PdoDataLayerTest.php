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
	
	public function testRead(){
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$users = Sql::table('users');
		$select = $users->project('*');
		$select->engine($userMapper);
		$this->layer->read($select);
		
		$this->layer->close();
	}
	
	public function testMapper(){
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = $userMapper->findBy(array('firstName' => 'Marco', 'lastName' => 'Trognoni', 'id' => 2));
		print_r($user);
	}
	
}