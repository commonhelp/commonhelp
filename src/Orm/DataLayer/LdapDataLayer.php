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
	
	protected $options;
	
	
	public function __construct(array $options){
		$this->options = $options;
		$this->reader = null;
		$this->writer = null;
	}
	
	public function connect(){
		$this->session = new LdapSession($this->options);
		$this->reader = $this->session->getReader();
		$this->writer = $this->session->getWriter();
	}
	
	public function read(AstManager $manager){
		if(is_null($this->reader)){
			throw new DataLayerException('No ldap connection');
		}
		$records = array();
		if(!($manager instanceof AstFilterManager)){
			throw new DataLayerException('Bad manager filter');
		}
		$filter = $this->clean($manager->toFilter());
		$attributes = $manager->attributes();
		if(null !== $attributes){
			$this->reader->setAttribute($attributes);
		}
		$ldapRs = $this->reader->search($this->session->getBaseDn(), $filter);
		$i=0;
		foreach($ldapRs as $rs){
			foreach($rs as $key => $vals){
				if(is_array($vals) && count($vals) < 2){
					$records[$i][$key] = $vals[0];
				}else{
					$records[$i][$key] = $vals;
				}
			}
			$i++;
		}
		
		return $records;
	}
	
	public function write(AstManager $manager){
		if(is_null($this->writer)){
			throw new DataLayerException('No ldap connection');
		}
		throw new DataLayerException('Not implemented yet');
	}
	
	public function close(){
		$this->session->disconnect();
		$this->session = null;
	}
	
	protected function clean($str){
		return preg_replace('/\s+/', '', $str);
	}
	
}
