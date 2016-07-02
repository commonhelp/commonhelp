<?php
namespace Commonhelp\Ssh\Auth;

use Commonhelp\Resource\Auth;

class Agent implements Auth{
	
	protected $username;
	
	public function __construct($username){
		$this->username = $username;
	}
	
	public function authenticate($session){
		return ssh2_auth_agent(
				$session,
				$this->username
		);
	}
	
}

?>