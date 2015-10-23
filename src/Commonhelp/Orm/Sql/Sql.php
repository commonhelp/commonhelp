<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\PdoDataLayer;
use Commonhelp\Util\Inflector;
class Sql implements \ArrayAccess{
	
	protected $table;
	
	
	public function __construct($table){
		$this->table = $table;
	}
	
	public static function table($table){
		return new static($table);
	}
	
	public function getTable(){
		return $this->table;
	}
	
	public function alias(){
		
	}
	
	public function from(Sql $table){
		return new SelectManager($table);
	}
	
	public function join(){
		
	}
	
	public function group(){
		$args = func_get_args();
		return call_user_func_array(array($this->from($this), 'group'), $args);
	}
	
	public function order(){
		$args = func_get_args();
		return call_user_func_array(array($this->from($this), 'order'), $args);
	}
	
	public function where($condition){
		return $this->from($this)->where($condition);
	}
	
	public function take($amount){
		return $this->from($this)->take($amount);
	}
	
	public function skip($amount){
		return $this->from($this)->skip($amount);
	}
	
	public function project(){
		$args = func_get_args();
		return call_user_func_array(array($this->from($this), 'project'), $args);
	}
	
	public function distinct($value = true){
		return $this->from($this)->distinct($value);
	}
	
	public function having($condition){
		return $this->from($this)->having($condition);
	}
	
	public function getSelectManager(){
		return new SelectManager();
	}
	
	public function getInsertManager(){
		return new InsertManager();
	}
	
	public function getDeleteManager(){
		return new DeleteManager();
	}
	
	public function getUpdateManager(){
		return new UpdateManager();
	}
	
	
	public function offsetGet($offset) {
		return new AttributeNode($offset, $this);
	}
	
	public function offsetUnset($offset) {
	}
	
	public function offsetExists($offset) {
	}
	
	public function offsetSet($offset, $value) {
	}
	
	public function toString(){
		return $this->table;
	}
	
	public function __toString(){
		return $this->toString();
	}
	
	public function buildSelect(array $criteria, $orderby, $limit, $offset){
		$select = $this->project('*');
		$select->where($this->criteriaToConditions($criteria));
	
		if(!is_null($orderby)){
			foreach($orderby as $field => $value){
				$field = Inflector::underscore($field);
				if($value == 'ASC'){
					$orders[] = $this[$field]->asc($value);
				}else if($value == 'DESC'){
					$orders[] = $this[$field]->desc($value);
				}else{
					throw new SqlException("{$value} is not a valid operation for ordering");
				}
			}
			
			call_user_func_array(array($select, 'order'), $order);
		}
	
		if(!is_null($limit)){
			$select->take($limit);
		}
	
		if(!is_null($offset)){
			$select->skip($offset);
		}
		
		return $select;
	}
	
	public function buildInsert(array $map){
		$insert = new InsertManager();
		$mapToInsert = $this->mapToStmnt($map);
		$insert->insert($mapToInsert);
		
		return $insert;
	}
	
	public function buildDelete($criteria, $limit){
		$delete = new DeleteManager();
		$delete->from($this);
		$delete->where($this->criteriaToConditions($criteria));
		if(!is_null($limit)){
			$delete->take($limit);
		}
		
		return $delete;
	}
	
	public function buildUpdate(array $map, array $criteria){
		$update = new UpdateManager();
		$update->table($this);
		$mapToUpdate = $this->mapToStmnt($map);
		$update->set($mapToUpdate);
		$update->where($this->criteriaToConditions($criteria));
		return $update;
	}
	
	private function mapToStmnt($map){
		$mapTo = array();
		foreach($map as $field => $value){
			$field = Inflector::underscore($field);
			$mapTo[] = array($this[$field], $value);
		}
		
		return $mapTo;
	}
	
	private function criteriaToConditions($criteria){
		$conditions = array();
		foreach($criteria as $field => $value){
			$field = Inflector::underscore($field);
			$conditions[] = $this[$field]->eq($value);
		}
		
		return $conditions;
	}
	
}
