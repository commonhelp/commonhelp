<?php
namespace Commonhelp\Ssh;

use Commonhelp\Resource\Session;
use Commonhelp\Resource\AbstractResource;
use Commonhelp\Ssh\System\Exec;
use Commonhelp\Ssh\System\Sftp;
use Commonhelp\Ssh\System\PublicKey;
use Commonhelp\Resource\Auth;

class SshSession extends AbstractResource implements Session{
	protected $configuration;
	protected $subsystems;
	
	
	public function __construct(array $configuration, Auth $auth = null){
		$this->configuration = $configuration;
		$this->auth = $auth;
	}
	
	protected function createResource(){
		$resource = $this->connect($this->configuration);
		if (!is_resource($resource)) {
			throw new RuntimeException('The SSH connection failed.');
		}
		$this->resource = $resource;
		if (null !== $this->auth) {
			$this->auth();
		}
	}
	
	public function getExec(){
		return $this->getSubSystem('Exec');
	}
	
	public function getSftp(){
		return $this->getSubSystem('Sftp');
	}
	
	public function getPublicKey(){
		return $this->getSubSystem('PublicKey');
	}
	
	public function getSubSystem($name){
		if (!isset($this->subsystems[$name])) {
			$this->createSubSystem($name);
		}
		return $this->subsystems[$name];
	}
	
	protected function createSubSystem($name){
		switch ($name) {
			case 'Sftp':
				$subsystem = new Sftp($this);
				break;
			case 'PublicKey':
				$subsystem = new PublicKey($this);
				break;
			case 'Exec':
				$subsystem = new Exec($this);
				break;
			default:
				throw new \InvalidArgumentException(sprintf('The subsystem \'%s\' is not supported.', $name));
		}
		$this->subsystems[$name] = $subsystem;
	}
	
	public function connect(array $args){
		return call_user_func_array('ssh2_connect', $args);
	}
	
	protected function auth(){
		if(false === parent::auth()){
			throw new \RuntimeException('Invalid auth');
		}
	}
	
}


?>