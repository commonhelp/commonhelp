<?php
namespace Commonhelp\Orm;

use Commonhelp\Orm\Exception\EntityException;
use Commonhelp\Util\Inflector;

abstract class Entity{
	
	public $id;
	
	private $fieldTypes = array('id' => 'integer');
	private $updatedFields = array();
	
	public static function fromParams(array $params){
		$instance = new static();
		
		foreach($params as $key => $value){
			$method = 'set'.ucfirst($key);
			$instance->$method($value);
		}
		
		return $instance;
	}
	
	public static function fromRow(array $row){
		$instance = new static();
		
		foreach($row as $key => $value){
			$prop = ucfirst(Inflector::classify($key));
			$setter = 'set'.$prop;
			$instance->$setter($value);
		}
		
		$instance->resetUpdatedFields();
		
		return $instance;
	}
	
	protected function getter($name){
		if(property_exists($this, $name)){
			return $this->name;
		}else{
			throw new EntityException($name.' is not a valid attribute');
		}
	}
	
	protected function setter($name, $args){
		if(property_exists($this, $name)){
			if($this->$name === $args[0]){
				return;
			}
			
			$this->markUpdatedField($name);
			if($args[0] !== null && array_key_exists($name, $this->fieldTypes)) {
				settype($args[0], $this->fieldTypes[$name]);
			}
			$this->$name = $args[0];
			
		}else{
			throw new EntityException($name.' is not a valid attribute');
		}
	}
	
	public function __call($methodName, $args){
		$attr = lcfirst( substr($methodName, 3) );
		if(strpos($methodName, 'set') === 0){
			$this->setter($attr, $args);
		} elseif(strpos($methodName, 'get') === 0) {
			return $this->getter($attr);
		} else {
			throw new EntityException($methodName.' doesn\'t exists');
		}
	}
	
	public function classify($attribute){
		return lcfirst(Inflector::classify($attribute));
	}
	
	public function tabelize($fieldName){
		return Inflector::tableize(ucfirst($fieldName));
	}
	
	public function markUpdatedField($field){
		$this->updatedFields[$field] = true;
	}
	
	public function getUpdatedFields(){
		return $this->updatedFields;	
	}
	
	public function resetUpdatedFields(){
		$this->updatedFields = array();
	}
	
	protected function addType($fieldName, $type){
		$this->fieldTypes[$fieldName] = $type;
	}
	
}