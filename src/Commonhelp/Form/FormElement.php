<?php

namespace Commonhelp\Form;

class FormElement implements \IteratorAggregate{
	
	private $attributes;
	private $isInline = false;
	private $isValueInside = false;
	private $value;
	private $type;
	
	private $children;
	
	public function __construct($tagName, $isInline=false){
		$this->isInline = $isInline;
		$this->setHTMLTag($tagName);
	}
	
	public function setId($id){
		$this->attributes['id'] = $id;
		return $this;
	}
	
	public function setName($name){
		$this->attributes['name'] = $name;
		return $this;
	}
	
	public function setType(FormType $type){
		$this->type = $type;
		$this->setAttributes($type->attributes());
		return $this;
	}
	
	public function setValue($value){
		if(!$this->isValueInside)
			$this->attributes['value'] = $value;
		$this->value = $value;
		return $this;
	}
	
	public function setAttributes(array $attrs){
		array_merge($this->attributes, $attrs);
	}
	
	public function valueInside(){
		$this->isValueInside = true;
		if(isset($this->attributes['value'])){
			unset($this->attributes['value']);
		}
		
		return $this;
	}
	
	public function isValueInside(){
		return $this->isValueInside;
	}
	
	public function getValue(){
		return $this->value;
	}
	
	public function addChild(FormElement $child){
		$this->children[] = $child;
	}
	
	public function getIterator(){
		return new \ArrayIterator($this->children);
	}
}