<?php
namespace Commonhelp\Orm;

class EntityManager{
	
	private $connection;
	private $unitOfWork;
	
	public function __construct(DataLayerInterface $connection){
		$this->connection = $connection;
		$this->unitOfWork = new UnitOfWork($this);
	}
	
	public function getConnection(){
		return $this->connection;
	}
	
	public function getUnitOfWork(){
		return $this->unitOfWork;
	}
	
	public function persist(Entity $entity){
		
	}
	
	public function dirty(Entity $entity){
		
	}
	
	public function remove(Entity $entity){
		
	}
	
	public function copy(Entity $entity, $deep = false){
		
	}
	
	public function contains(Entity $entity){
		
	}
}