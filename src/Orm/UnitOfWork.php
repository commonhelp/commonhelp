<?php
namespace Commonhelp\Orm;

class UnitOfWork{

	const STATE_NEW = 1;
	const STATE_DIRTY = 2;
	const STATE_REMOVE = 3;
	
	private $identityMap;
	
	public function registerNew(){
		
	}
	
	public function registerDirty(){
		
	}
	
	public function registerRemove(){
		
	}
	
	public function commit(Entity $entity=null){
		
	}
	
}