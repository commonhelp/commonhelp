<?php

namespace Commonhelp\Ldap;

use Commonhelp\Resource\AbstractResource;
use Commonhelp\Resource\Session;

class LdapSession extends AbstractResource implements Session{
	
	protected $useSsl;
	protected $useStartTls;
	protected $useUri;
	protected $port;
	protected $networkTimeout;
	protected $connectString;
	protected $host;
	
	protected $baseDn;
	
	
	public function __construct($options = array()){
		if(!extension_loaded('ldap')){
			throw new \RuntimeException('LDAP extension not loaded');
		}
		$this->setOptions($options);
		$username = isset($options['username']) ? $options['username'] : null;
		$password = isset($options['password']) ? $options['password'] : null;
		$this->auth = new Bind($username, $password);
	}
	
	protected function createResource(){
		$resource = ($this->useUri) ? $this->connect(array($this->connectString)) : $this->connect(array($this->host, $this->port));
		if (!is_resource($resource)) {
			throw new \RuntimeException('Unable to connect on: '.$this->connectString);
		}
		$this->resource = $resource;
		if (ldap_set_option($resource, LDAP_OPT_PROTOCOL_VERSION, 3)){
			if ($this->networkTimeout) {
				ldap_set_option($resource, LDAP_OPT_NETWORK_TIMEOUT, $this->networkTimeout);
			}
		}
		if (null !== $this->auth) {
			$this->auth();
		}
	}
	
	public function connect(array $args){
		return call_user_func_array('ldap_connect', $args);
	}
	
	public function __destruct(){
		$this->disconnect();
	}
	
	public function disconnect(){
		if(is_resource($this->resource)){
			ldap_unbind($this->resource);
		}
		
		$this->resource = null;
		
		return $this;
	}
	
	public function getReader(array $attributes=array(), $attrsOnly=0, $limit=0){
		return new LdapReader($this, $attributes, $attrsOnly, $limit);
	}
	
	public function getWriter(){
		return new LdapWriter($this);
	}
	
	public function getBaseDn(){
		return $this->baseDn;
	}
	
	protected function auth(){
		if(false === parent::auth()){
			throw new \RuntimeException(ldap_error($this->resource));
		}
	}
	
	protected function setOptions(array $options){
		$this->host = isset($options['host']) ? $options['host'] : false;
		$this->useSsl = isset($options['usessl']) ? $options['usessl'] : false;
		$this->useStartTls = isset($options['usestarttls']) ? $options['usestarttls'] : false;
		$this->port = isset($options['port']) ? $options['port'] : '389';
		$this->networkTimeout = isset($options['networktimeout']) ? $options['networktimeout'] : null;
		$this->connectString = $this->setHost($this->host);
		$this->baseDn = isset($options['basedn']) ? $options['basedn'] : null;
	}
	
	protected function setHost($host){
		$this->useUri = false;
		$h = '';
		if (preg_match_all('~ldap(?:i|s)?://~', $host, $hosts, PREG_SET_ORDER) > 0) {
			$h = $host;
			$this->useUri = true;
			$this->useSsl = true;
		}else{
			if($this->useSsl){
				$h = 'ldaps://' . $host;
				$this->useUri = true;
			}else{
				$h = 'ldap://' . $host;
			}
			if($this->port){
				$h .= ':' . $this->port;
			}
		}
		
		return $h;
	}
	
	
	
}

?>