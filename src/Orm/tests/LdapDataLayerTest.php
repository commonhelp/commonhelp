<?php

namespace Commonhelp\Orm;

use Commonhelp\Ldap\AstFilterManager;
class LdapDataLayerTest extends \PHPUnit_Framework_TestCase{
	
	protected $options = array(
			'host' 		=> 'ponteserver.unponteper.it',
			'username' => 'cn=admin,dc=unponteper,dc=it',
			'password' => 'Missioni2010',
			'basedn' => 'dc=unponteper,dc=it'
	);
	
	protected $baseDn = 'dc=unponteper,dc=it';
	
	public function testConnection(){
		$connection = LdapDataLayer::instance($this->options);
	} 
	
	public function testRead(){
		$layer = new LdapDataLayer($this->options);
		//(&(|(objectClass=sambaAccount)(objectClass=sambaSamAccount))(objectClass=posixAccount)(!(uid=*$)))
		$filter = new AstFilterManager();
		$filter->filter($filter['objectClass']->eq('posixAccount')
				->also($filter['objectClass']->eq('sambaAccount')));
		print_r($layer->read($filter));
		
		$layer->close();
	}
	
}
	

