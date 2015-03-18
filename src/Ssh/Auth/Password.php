<?php
namespace Commonhelp\Ssh;

use Commonhelp\Authentication\Auth;

class Password implements Auth{
	
	protected $username;
	protected $password;
	
	public function __construct($username, $password){
		$this->username = $username;
		$this->password = $password;
	}
	
	public function authenticate($session){
		return @ssh2_auth_password($session, $this->username, $this->password);
	}
	
}

?>