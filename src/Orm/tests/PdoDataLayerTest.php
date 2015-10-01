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
	
	public function testFind(){
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = $userMapper->findBy(array('firstName' => 'Marco', 'lastName' => 'Trognoni'));
		$userTest = \Test\Pdo\User::fromRow(array('id'=>1, 'firstName' => 'Marco', 'lastName' => 'Trognoni'));
		
		$this->assertEquals($userTest, $user);
	}
	
	public function testInsert(){
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = new \Test\Pdo\User();
		$user->setFirstName('Luca');
		$user->setLastName('Trognoni');
		
		//$userMapper->create($user);
		
	}
	
	public function testUpdate(){
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = $userMapper->findBy(array('firstName' => 'Luca', 'lastName' => 'Trognoni'));
		if(!is_null($user)){
			$user->setLastName('Trognoni-Visco');
			$user->setEmail('luca.trognoni@gmail.com');
		}
		
		//$userMapper->update($user);
	}
	
	public function testDelete(){
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = $userMapper->findBy(array('firstName' => 'Luca', 'lastName' => 'Trognoni-Visco'));
		if(!is_null($user)){
			//$userMapper->delete($user);
		}
	}
	
}