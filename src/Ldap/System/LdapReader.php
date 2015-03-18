<?php
namespace Commonhelp\Ldap;

use Commonhelp\Resource\SubSystem;
use Commonhelp\Resource\Session;

class LdapReader extends SubSystem{
	
	protected $attributes;
	protected $attrsOnly;
	protected $limit;
	protected $sort;
	
	public function __construct(Session $session, array $attributes=array(), $sort=null, $limit=0){
		parent::__construct($session);
		$this->attributes = $attributes;
		$this->attrsOnly = 0;
		$this->limit = $limit;
		$this->sort = $sort;
	}
	
	protected function createResource(){
		$this->resource = $this->getSessionResource();
	}
	
	public function read($dn, $filter){
		$dnStr = $this->checkDn($dn);
		if(false === ($read = @ldap_read($this->getResource(), $dnStr, $filter, $this->attributes, $this->attrsOnly, $this->limit))){
			throw new \RuntimeException('errno:'.ldap_errno($this->getResource()).' error:'.ldap_error($this->getResource()));
		}
		if($this->sort !== null && is_string($this->sort)){
			$read = $this->sort($read);
		}
		return ldap_get_entries($this->getResource(), $read);
	}
	
	public function llist($dn, $filter){
		$dnStr = $this->checkDn($dn);
		if(false === ($list = @ldap_list($this->getResource(), $dnStr, $filter, $this->attributes, $this->attrsOnly, $this->limit))){
			throw new \RuntimeException('errno:'.ldap_errno($this->getResource()).' error:'.ldap_error($this->getResource()));
		}
		if($this->sort !== null && is_string($this->sort)){
			$list = $this->sort($list);
		}
		return ldap_get_entries($this->getResource(), $list);
	}
	
	public function search($dn, $filter){
		$dnStr = $this->checkDn($dn);
		if(false === ($search = @ldap_search($this->getResource(), $dnStr, $filter, $this->attributes, $this->attrsOnly, $this->limit))){
			throw new \RuntimeException('errno:'.ldap_errno($this->getResource()).' error:'.ldap_error($this->getResource()));
		}
		if($this->sort !== null && is_string($this->sort)){
			$search = $this->sort($search);
		}
		return ldap_get_entries($this->getResource(), $search);
	}
	
	public function sort($rs, $sort=null){
		if(null === $sort){
			$sort = $this->sort;
		}
		if(!@ldap_sort($this->getResource(), $rs, $sort)){
			throw new \RuntimeException(ldap_error($this->getResource()));
		}
		
		return $rs;
	}
	
	public function setAttribute($attr){
		if(is_array($attr)){
			array_merge($this->attributes, $attr);
		}else{
			$this->attributes[] = $attr;
		}
	}
	
	public function setAttrsOnly($attrsonly){
		$this->attrsOnly = $attrsonly;
	}
	
	public function setLimit($limit){
		$this->limit = $limit;
	}
	
	public function setSort($sort){
		$this->sort = $sort;
	}
	
	protected function checkDn($dn){
		if($dn instanceof Dn){
			$dnStr = $dn->toString();
		}else{
			Dn::checkDn($dn);
			$dnStr = $dn;
		}
		
		return $dnStr;
	}
	
}