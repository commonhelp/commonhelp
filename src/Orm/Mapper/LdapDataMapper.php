<?php

namespace Commonhelp\Orm;

use Commonhelp\Ldap\AstFilterManager;

abstract class LdapDataMapper extends Mapper{
	
	protected $layer;
	protected $entityName;
	
	protected $queryManager;
	
	public function __construct(LdapDataLayer $layer, $entityName = null){
		$this->layer = $layer;
		if(!is_null($entityName)){
			$this->entityName = $entityName;
		}else{
			$this->entityName = str_replace('Mapper', '', get_class($this));
		} 
	}
	
	public function getVisitor(){
		return $this->layer->getVisitor();
	}
	
	public function create(Entity $entity){
		$args = $this->parseArgs(func_get_args());
	}
	
	public function find(AstFilterManager $filter){
		$rows = $this->layer->read($filter);
		$results = $this->getEntities($rows);
		if(count($results) < 2){
			return $results[0];
		}
		
		return $results;
	}
	
	public function read(){
		return $this->find(func_get_args());
	}
	
	public function update(Entity $entity){
	}
	
	public function delete(Entity $entity){
	}
	
}

