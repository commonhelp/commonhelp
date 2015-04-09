<?php

namespace Commonhelp\Orm;

use Commonhelp\Ldap\LdapSession;
use Commonhelp\Ldap\LdapReader;
use Commonhelp\Ldap\LdapWriter;

class LdapDataLayer extends DataLayerInterface{
	/**
	 * 
	 * Implements an object adatper;
	 */
	protected $reader;
	protected $writer;
	protected $session;
	
	
	public function __construct(array $options){
		$this->session = new LdapSession($options);
		$this->reader = $this->session->getReader();
		$this->writer = $this->session->getWriter();
	}
	
}
