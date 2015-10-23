<?php

namespace Commonhelp\Orm;

use Commonhelp\Orm\Exception\DataMapperException;
use Commonhelp\Util\Inflector;
use Commonhelp\Orm\Sql\SelectManager;
use Commonhelp\Orm\Sql\Sql;
use Commonhelp\Orm\Sql\DeleteManager;
use Commonhelp\Orm\Exception\Commonhelp\Orm\Exception;

abstract class PdoDataMapper extends Mapper{
	
	protected $layer;
	protected $locator;
	protected $entityName;
	protected $tableName;
	protected $table;
	
	protected $queryManager;
	
	public function __construct(PdoDataLayer $layer, $entityName=null){
		$this->layer = $layer;
		if(!is_null($entityName)){
			$this->entityName = $entityName;
		}else{
			$this->entityName = str_replace('Mapper', '', get_class($this));
		}

		$this->tableName = Inflector::tableize(substr($this->entityName, strrpos($this->entityName, '\\') + 1));
		$this->table = Sql::table($this->tableName);
	}
	
	public function __call($name, $arguments){
		if(empty($arguments)){
			throw new DataMapperException("{$name} invalid call - no parameter submitted");
		}
		switch (true) {
			case (0 === strpos($name, 'findBy')):
				$by = substr($name, 6);
				$method = 'findBy';
				break;
			case (0 === strpos($name, 'findOneBy')):
				$by = substr($name, 9);
				$method = 'findOneBy';
				break;
			default:
				throw new DataMapperException("Undefined method {$name}. The method name must start with ".
				"either findBy or findOneBy!");
		}
		
		$fieldName = lcfirst(Inflector::classify($by));
	
		switch (count($arguments)) {
			case 1:
				return $this->$method(array($fieldName => $arguments[0]));
			case 2:
				return $this->$method(array($fieldName => $arguments[0]), $arguments[1]);
			case 3:
				return $this->$method(array($fieldName => $arguments[0]), $arguments[1], $arguments[2]);
			case 4:
				return $this->$method(array($fieldName => $arguments[0]), $arguments[1], $arguments[2], $arguments[3]);
			default:
				// Do nothing
		}
	}
	
	public function getVisitor(){
		return $this->layer->getVisitor();
	}
	
	public function create(Entity $entity){
		$map = $this->mapUpdatedField($entity);
		$insert = $this->table->buildInsert($map);
		$insert->engine($this);
		
		$insertId = $this->layer->write($insert);
		$entity->setId($insertId);
		
		return $entity;
	}
	
	public function find($id){
		if($id instanceof SelectManager){
			$select = $id;	
		}else if(is_int($id)){
			$select = $this->table->buildSelect(array('id' => $id), null, null, null);
		}else{
			throw new DataMapperException("{$id} is not a valid parameter. Should be an integer id or a SelectManager instance");
		}
		
		$select->engine($this);
		$results = $this->layer->read($select);
		if(count($results) < 2){
			return $this->getEntity($results);
		}
		
		return $this->getEntities($results);
	}
	
	public function findOneBy($select, array $orderby = null){
		if(!($select instanceof SelectManager)){
			$select = $this->table->buildSelect($select, $orderby, null, null);
		}
		
		$select->take(1);
		$select->engine($this);
		$results = $this->layer->read($select);
		
		return $this->getEntity($results);
		
	}
	
	public function findBy($select, array $orderby = null, $limit = null, $offset = null){
		if(!($select instanceof SelectManager)){
			$select = $this->table->buildSelect($select, $orderby, $limit, $offset);
		}
		
		$select->engine($this);
		$results = $this->layer->read($select);
		if(count($results) < 2){
			return $this->getEntity($results);
		}
		
		return $this->getEntities($results);
	}
	
	public function read(){
		return $this->find(func_get_args());
	}
	
	public function update(Entity $entity){
		$map = $this->mapUpdatedField($entity);
		$update = $this->table->buildUpdate($map, array('id' => $entity->getId()));
		$update->engine($this);
		
		$this->layer->write($update);
		return $entity;
	}
	
	public function delete($entity, $limit=null){
		if($entity instanceof DeleteManager){
			$delete = $entity;
		}else if($entity instanceof Entity){
			$delete = $this->table->buildDelete(array('id' => $entity->getId()), 1);
		}else if(is_array($entity)){
			$delete = $this->table->buildDelete($entity, $limit);
		}else{
			throw new DataMapperException("Invalid arguments type you must use Entity or DeleteManager type instance or a criteria array: "
					.gettype($entity)." given");
		}
		
		$delete->engine($this);
		
		$this->layer->write($delete);
	}
	
	

	
}

