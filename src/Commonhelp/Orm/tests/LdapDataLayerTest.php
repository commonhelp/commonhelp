<?php

namespace Commonhelp\Orm;

use Commonhelp\Ldap\AstFilterManager;
use Commonhelp\Orm\DataLayer\LdapDataLayer;
class LdapDataLayerTest extends \PHPUnit_Framework_TestCase{
	
	protected $options = array(
			'host' 		=> 'stargate.unponteper.it',
			'username' => 'cn=admin,dc=unponteper,dc=it',
			'password' => 'Missioni2010',
			'basedn' => 'dc=unponteper,dc=it'
	);
	
	protected $baseDn = 'dc=unponteper,dc=it';
	protected $layer;
	
	public function __construct(){
		$this->layer = new LdapDataLayer($this->options);
		$this->layer->connect();
	}
	
	public function __destruct(){
		$this->layer->close();
	}
	
	public function testConnection(){
		$connection = LdapDataLayer::instance($this->options);
	} 
	
/*	public function testRead(){
		$filter = new AstFilterManager();
		$filter->filter($filter['uid']->eq('*'));
		$results = $this->layer->read($filter);
		
		$this->layer->close();
	}
	
	public function testLdapMapper(){
		$userMapper = new \Test\Ldap\UserMapper($this->layer);
		$filter = new AstFilterManager();
		$filter->filter($filter['uid']->eq('*'));
		$userMapper->find($filter);
	}
*/	
}
	

