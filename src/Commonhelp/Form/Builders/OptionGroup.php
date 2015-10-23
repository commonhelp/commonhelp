<?php

namespace Commonhelp\Form\Builders;

class OptionGroup extends FormBuilder{
	
	public function __construct(){
		$this->element = new FormElement('optgroup');
	}
	
	public function addOption(Option $option){
		$this->element->addChild($option->getFormElement());
	}
	
}