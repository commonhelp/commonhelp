<?php

namespace Commonhelp\Config;

use Commonhelp\Util\Collections\ArrayCollection;
class Config extends ArrayCollection{
	
	protected $ldap = array(
			'host' 		=> 'ponteserver.unponteper.it',
			'username' => 'cn=admin,dc=unponteper,dc=it',
			'password' => 'Missioni2010',
			'basedn' => 'dc=unponteper,dc=it'
	);
	
	protected $pdo = array(
			'dsn'			=> 'mysql:host=localhost;dbname=test;charset=UTF8',
			'username'		=> 'test',
			'password'		=> 'test'
	);
	
	public function __construct(){
		$this['pdo'] = $this->pdo;
		$this['ldap'] = $this->ldap;
	}
}

