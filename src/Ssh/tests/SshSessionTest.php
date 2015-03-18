<?php
namespace Commonhelp\Ssh;

use Commonhelp\Authentication\Password;
class SshSessionTest extends \PHPUnit_Framework_TestCase{
	
	protected $configuration = array(
		'host' 		=> '192.168.1.10',
		'port' 		=> '22',
		'methods'	=> array(), 
		'callbacks'	=> array()
	);
	
	protected $cmd = 'echo "hello ssh world"';
	
	protected $login = array(
		'username' => 'marcoski',
		'password' => '3n1af338'
	);
	
	public function testConnection(){
		$session = new SshSession($this->configuration);
		$exec = $session->getExec();
		
		$this->assertEquals('SSH2 Session', get_resource_type($exec->getResource()));
		
	}
	
	public function testPasswordAuth(){
		$auth = new Password($this->login['username'], $this->login['password']);
		$session = new SshSession($this->configuration, $auth);
		$session->getResource();
	}
	
	public function testExec(){
		$auth = new Password($this->login['username'], $this->login['password']);
		$session = new SshSession($this->configuration, $auth);
		$exec = $session->getExec();
		
		$output = $exec->run($this->cmd);
		
		$this->expectOutputString('hello ssh world'.PHP_EOL);
		print $output;
	}
	
}

?>