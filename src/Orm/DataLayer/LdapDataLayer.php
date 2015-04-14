<?php

namespace Commonhelp\Orm;

use Commonhelp\Ldap\LdapSession;
use Commonhelp\Ldap\LdapReader;
use Commonhelp\Ldap\LdapWriter;
use Commonhelp\Util\Expression\AstManager;
use Commonhelp\Ldap\AstFilterManager;
use Commonhelp\Orm\Exception\DataLayerException;


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
	
	public function read(AstManager $manager){
		if(!($manager instanceof AstFilterManager)){
			throw new DataLayerException('Bad manager filter');
		}
		$filter = $this->clean($manager->toFilter());
		return $this->reader->search($this->session->getBaseDn(), $filter);
	}
	
	public function write(AstManager $manager){
		
	}
	
	public function close(){
		static::$instance = null;
	}
	
	protected function clean($str){
		return preg_replace('/\s+/', '', $str);
	}
	
}
