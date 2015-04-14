<?php

namespace Commonhelp\Orm;

use Commonhelp\Ldap\LdapSession;
use Commonhelp\Ldap\LdapReader;
use Commonhelp\Ldap\LdapWriter;
use Commonhelp\Util\Expression\AstManager;
use Commonhelp\Ldap\AstFilterManager;
use Commonhelp\Orm\Exception\DataLayerException;
use Commonhelp\Orm\Exception\Commonhelp\Orm\Exception;


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
		throw new DataLayerException('Not implemented yet');
	}
	
	public function close(){
		static::$instance = null;
	}
	
	protected function clean($str){
		return preg_replace('/\s+/', '', $str);
	}
	
}
