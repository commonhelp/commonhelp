<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\PdoDataLayer;
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
	
}
