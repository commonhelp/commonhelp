<?php

namespace Commonhelp\Orm;

use Commonhelp\Ldap\AstFilterManager;
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
	}
	
	public function testConnection(){
		$connection = LdapDataLayer::instance($this->options);
	} 
	
	public function testRead(){
		$filter = new AstFilterManager();
		$filter->filter($filter['uid']->eq('*'));
		$results = $this->layer->read($filter);
		
		$this->layer->close();
	}
	
	public function testOdm(){
		$locator = new Locator($this->layer);
		$mapper = $locator->mapper('Entity\User');
		$filter = new AstFilterManager();
		$filter->filter($filter['uid']->eq('*'));
		$users = $mapper->find($filter);
	}
	
}
	

