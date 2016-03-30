<?php
namespace Commonhelp\Form;

use Commonhelp\Util\Inflector;
use Commonhelp\Event\EventDispatcher;

class FormRegistry{
	
	private $types = array();
	
	private $builders = array();
	
	public function __construct(){
		
	}
	
	public function getType($type){
		$name = '';
		if(preg_match("/Types\\\([^\d]+)/", $type, $match)){
			$name = Inflector::underscore($match[1]);
		}else{
			throw new \InvalidArgumentException(sprintf('Invalid type name for type "%s"', $type));
		}
		if(!isset($this->types[$name])){
			$typeObj = null;
			if(class_exists($type) && in_array('Commonhelp\Form\FormType', class_implements($type))){
				$typeObj = new $type;
			}else{
				throw new \InvalidArgumentException(sprintf('Could not load type "%s"', $type));
			}
			
			$this->types[$name] = $typeObj;
		}
		return $this->types[$name];
	}
	
	public function getBuilder($builder, $fullName, FormType $type){
		$name = '';
		if(preg_match("/Builders\\\([^\d]+)/", $builder, $match)){
			$name = Inflector::underscore($match[1]);
		}else{
			throw new \InvalidArgumentException(sprintf('Invalid builder name for builder "%s"', $builder));
		}
		$key = hash('sha256', serialize(array($name, $type->getName())));
		
		$builderObj = null;
		if(class_exists($builder) && in_array('Commonhelp\Form\FormBuilder', class_parents($builder))){
			$builderObj = new $builder(new EventDispatcher(), $fullName);
			$builderObj->setType($type);
		}else{
			throw new \InvalidArgumentException(sprintf('Could not load builder "%s"', $builder));
		}
	
		return $builderObj;
	}
	
}