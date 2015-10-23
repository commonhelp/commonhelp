<?php

namespace Commonhelp\Form\Builders;

class Option extends FormBuilder{
	
	private $isSelected = false;
	
	public function __construct(){
		$this->element = new FormElement('option', true);
	}
	
	public function setSelected(){
		$this->isSelected = true;
		$this->element->setAttributes(array('selected' => ''));
	}
	
}