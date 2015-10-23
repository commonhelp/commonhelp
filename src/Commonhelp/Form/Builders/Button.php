<?php

namespace Commonhelp\Form\Builders;

class Button extends FormBuilder{
	
	public function __construct(){
		$this->element = new FormElement('button');
		$this->element->valueInside();
		$this->element->setType(new ButtonType());
	}
	
	public function doSubmit(){
		$this->element->setType(new SubmitType());
	}
	
	public function doReset(){
		$this->element->setType(new ResetType());
	}
	
	public function getFormElement(){
		return $this->element;
	}
	
}

?>