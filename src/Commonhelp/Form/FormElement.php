<?php

namespace Commonhelp\Form;

use Commonhelp\Form\Types\AbstractType;

class FormElement implements \ArrayAccess, \IteratorAggregate{
	
	private $unreslovedChildren;
	private $children;
	private $attributes;
	private $creator;
	private $tag;
	private $type;
	
	public function __construct($tagName, $attributes = array()){
		$this->tag = $tagName;
		$this->attributes = $attributes;
		$this->children = array();
		$this->creator = null;
		$this->type = null;
	}
	
	public function getTag(){
		return $this->tag;
	}
	
	public function setType(FormType $type){
		$this->type = $type;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function setCreator(FormCreator $creator){
		$this->creator = $creator;
	}
	
	public function offsetGet($child){
		if(isset($this->unreslovedChildren[$child])){
			return $this->unreslovedChildren[$child];
		}
		
		return null;
	}
	
	public function offsetSet($child, $builder){
		$this->unreslovedChildren[$child] = $builder;
	}
	
	public function offsetExists($child){
		return array_key_exists($child, $this->unreslovedChildren);
	}
	
	public function offsetUnset($child){
		if(isset($this->unreslovedChildren[$child])){
			unset($this->unreslovedChildren[$child]);
		}
	}
	
	public function has($attribute){
		return isset($this->attributes[$attribute]);
	}
	
	public function get($attribute){
		if(isset($this->attributes[$attribute])){
			return $this->attributes[$attribute];
		}
		
		return null;
	}
	
	public function set($attribute, $value){
		$this->attributes[$attribute] = $value;
	}
	
	public function reset($attribute){
		if(isset($this->attributes[$attribute])){
			unset($this->attributes[$attribute]);
		}
	}
	
	public function all(){
		return $this->attributes;
	}
	
	public function getIterator(){
		return new \ArrayIterator($this->children);
	}
	
	public function resolveChildern(){
		foreach($this->unreslovedChildren as $name => $info){
			$this->children[$name] = $this->create($name, $info['type'], $info['builder'], $info['options']);
		}
	}
	
	public function create($name, $type, $builder, $options){
		return $this->creator->createNamedBuilder($name, $builder, $type, $options);
	}
}