<?php

namespace Commonhelp\Form;

abstract class FormBuilder{
	
	protected $element;
	
	public function setName($name){
		$this->element->setName($name);
	}
	
	public function setId($id){
		$this->element->setId($id);
		return $this;
	}
	
	public function setValue($value){
		$this->element->setValue($value);
		return $this;
	}
	
	public function setAttributes(array $attrs){
		$this->element->setAttributes($attrs);
		return $this;
	}
	
	public function getFormElement(){
		return $this->element;
	}
}

?>