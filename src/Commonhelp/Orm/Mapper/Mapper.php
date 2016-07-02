<?php

namespace Commonhelp\Orm\Mapper;

abstract class Mapper{
	
	abstract public function create(Entity $entity);
	
	abstract public function read();
	
	abstract public function update(Entity $entity);
	
	abstract public function delete($entity, $limit=null);
	
	protected function mapRowToEntity($row){
		return call_user_func($this->entityName .'::fromRow', $row);
	}
	
	protected function getEntities(array $rows){
		$entities = [];
		foreach($rows as $key => $row){
			$entities[] = $this->mapRowToEntity($row);
		}
		
		if(count($entities) > 1){
			return $entities;
		}
		
		return null;
	}
	
	protected function getEntity($row){
		if(isset($row[0])){
			return $this->mapRowToEntity($row[0]);
		}
		
		return null;
	}
	
	protected function mapUpdatedField(Entity $entity){
		$map = array();
		foreach($entity->getUpdatedFields() as $field => $valid){
			if($valid){
				$getter = "get".ucfirst($field);
				$map[$field] = $entity->$getter();
			}
		}
		
		return $map;
	}

}