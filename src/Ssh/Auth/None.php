<?php
namespace Commonhelp\Ssh;

use Commonhelp\Authentication\Auth;

class None implements Auth{
	
	protected $username;
	
	public function __construct($username){
		$this->username = $username;
	}
	
	public function authenticate($session){
		return true === ssh2_auth_none($session, $this->username);
	}
	
}

?>