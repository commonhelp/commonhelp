<?php

namespace Commonhelp\Orm;

use Commonhelp\Ldap\AstFilterManager;

abstract class LdapDataMapper implements Mapper{
	
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
	
	public function create(){
		$args = $this->parseArgs(func_get_args());
	}
	
	public function find(AstFilterManager $filter){
		$rows = $this->layer->read($filter);
		$entities = [];
		foreach($rows as $key => $row){
			$entities[] = $this->mapRowToEntity($row);
		}
		
		return $entities;
	}
	
	public function read(){
		return $this->find(func_get_args());
	}
	
	public function update(){
		$args = $this->parseArgs(func_get_args());
	}
	
	public function delete(){
		$args = $this->parseArgs(func_get_args());
	}
	
	protected function mapRowToEntity($row){
		return call_user_func($this->entityName .'::fromRow', $row);
	}
	
}

