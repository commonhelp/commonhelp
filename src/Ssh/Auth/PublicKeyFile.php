<?php
namespace Commonhelp\Ssh;

use Commonhelp\Authentication\Auth;

class PublicKeyFile implements Auth{
	
	protected $username;
	protected $publicKeyFile;
	protected $privateKeyFile;
	protected $passPhrase;
	
	public function __construct($username, $publicKeyFile, $privateKeyFile, $passPhrase = null){
		$this->username = $username;
		$this->publicKeyFile = $publicKeyFile;
		$this->privateKeyFile = $privateKeyFile;
		$this->passPhrase = $passPhrase;
	}
	
	public function authenticate($session){
		return ssh2_auth_pubkey_file(
			$session,
			$this->username,
			$this->publicKeyFile,
			$this->privateKeyFile,
			$this->passPhrase
		);
	}
	
}

?>