<?php

namespace Commonhelp\Orm;

abstract class Mapper{
	
	abstract public function create(Entity $entity);
	
	abstract public function read();
	
	abstract public function update(Entity $entity);
	
	abstract public function delete(Entity $entity);
	
	protected function mapRowToEntity($row){
		return call_user_func($this->entityName .'::fromRow', $row);
	}
	
	protected function getEntities(array $rows){
		$entities = [];
		foreach($rows as $key => $row){
			$entities[] = $this->mapRowToEntity($row);
		}
	
		return $entities;
	}
	
	protected function getEntity($row){
		return $this->mapRowToEntity($row[0]);
	}

}