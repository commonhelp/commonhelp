<?php
namespace Commonhelp\Ldap;

class LdapSessionTest extends \PHPUnit_Framework_TestCase{
	
	protected $options = array(
		'host' 		=> 'ponteserver.unponteper.it',
		'username' => 'cn=admin,dc=unponteper,dc=it',
		'password' => 'Missioni2010',
		'basedn' => 'dc=unponteper,dc=it'
	);
	
	protected $baseDn = 'dc=unponteper,dc=it';
	
	protected $validDn = 'cn=admin,dc=unponteper,dc=it';
	protected $invalidDn = 'cn=admin,dc=unponteper,dc';
	
	public function testConnection(){
		$session = new LdapSession($this->options);
		$res = $session->getResource();
		
		//print_r($res);
	}
	
	public function testValidDn(){
		Dn::factory($this->validDn);
	}
	
	public function testRead(){
		$session = new LdapSession($this->options);
		$reader = $session->getReader();
		
		$obj = $reader->search($session->getBaseDn(), 'objectClass=*');
		print_r($obj);
	}
	
}

?>