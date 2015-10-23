<?php
namespace Commonhelp\Ssh;

use Commonhelp\Authentication\Auth;

class HostBasedFile implements Auth{
	
	protected $username;
	protected $hostname;
	protected $publicKeyFile;
	protected $privateKeyFile;
	protected $passPhrase;
	protected $localUsername;
	
	public function __construct($username, $hostname, $publicKeyFile, $privateKeyFile, $passPhrase = null, $localUsername = null){
		$this->username = $username;
		$this->hostname = $hostname;
		$this->publicKeyFile = $publicKeyFile;
		$this->privateKeyFile = $privateKeyFile;
		$this->passPhrase = $passPhrase;
		$this->localUsername = $localUsername;
	}
	
	public function authenticate($session){
		return ssh2_auth_hostbased_file(
			$session,
			$this->username,
			$this->hostname,
			$this->publicKeyFile,
			$this->privateKeyFile,
			$this->passPhrase,
			$this->localUsername
		);
	}
	
}

?>