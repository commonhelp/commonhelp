<?php
namespace Commonhelp\Form;

class Form extends FormBuilder{
	
	public function __construct(){
		$this->element = new FormElement('form');
	}
	
	public function getFormElement(){
		return $this->element;
	}	
}