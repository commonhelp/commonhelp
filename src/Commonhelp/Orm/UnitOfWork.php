<?php
namespace Commonhelp\Orm;

class UnitOfWork{

	const STATE_NEW = 1;
	const STATE_DIRTY = 2;
	const STATE_REMOVE = 3;
	
	private $identityMap;
	private $readOnlyObjects;
	
	private $entityManager;
	
	
	public function __construct(EntityManager $em){
		$this->entityManager = $em;
	}
	
	public function registerNew(){
		
	}
	
	public function registerDirty(){
		
	}
	
	public function registerRemove(){
		
	}
	
	public function commit(Entity $entity=null){
		
	}
	
	public function clear(){
		
	}
	
	public function markReadOnly($object){
		
	}
	
	public function isReadOnly($object){
		
	}
	
	public function isInIdentityMap($object){
		
	}
	
	public function size(){
		$countArray = array_map(function($item){
			return count($item);
		}, $this->identityMap);
		
		return array_sum($countArray);
	}
	
	public function getIdentityMap(){
		return $this->identityMap;
	}
	
}