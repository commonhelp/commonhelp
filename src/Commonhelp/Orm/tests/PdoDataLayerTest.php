<?php

namespace Commonhelp\Orm;

use Commonhelp\Orm\Sql\Sql;
use Commonhelp\Orm\DataLayer\PdoDataLayer;
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
	
	public function testConnectionWithParam(){
		$connection = PdoDataLayer::instance($this->connection);
	}
	
	public function testConnectionWithoutParam(){
		$connection = PdoDataLayer::instance();
		$connection->connect($this->connection);
	}
	
	public function testRead(){
		$this->layer->connect();
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$users = Sql::table('users');
		$select = $users->project('*');
		$select->engine($userMapper);
		$this->layer->read($select);
		
		$this->layer->close();
	}
	
	public function testFind(){
		$this->layer->connect();
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = $userMapper->findBy(array('firstName' => 'Marco', 'lastName' => 'Trognoni'));
		$userTest = \Test\Pdo\User::fromRow(array('id'=>1, 'firstName' => 'Marco', 'lastName' => 'Trognoni'));
		
		$this->assertEquals($userTest, $user);
		$this->layer->close();
	}
	
	public function testInsert(){
		$this->layer->connect();
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = new \Test\Pdo\User();
		$user->setFirstName('Luca');
		$user->setLastName('Trognoni');
		
		//$userMapper->create($user);
		$this->layer->close();
	}
	
	public function testUpdate(){
		$this->layer->connect();
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = $userMapper->findBy(array('firstName' => 'Luca', 'lastName' => 'Trognoni'));
		if(!is_null($user)){
			$user->setLastName('Trognoni-Visco');
			$user->setEmail('luca.trognoni@gmail.com');
		}
		
		//$userMapper->update($user);
		$this->layer->close();
	}
	
	public function testDelete(){
		$this->layer->connect();
		$userMapper = new \Test\Pdo\UserMapper($this->layer);
		$user = $userMapper->findBy(array('firstName' => 'Luca', 'lastName' => 'Trognoni-Visco'));
		if(!is_null($user)){
			//$userMapper->delete($user);
		}
		$this->layer->close();
	}
	
}