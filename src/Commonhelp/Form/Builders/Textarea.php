<?php

namespace Commonhelp\Form\Builders;

class Textarea extends FormBuilder{
	
	public function __construct(){
		$this->element = new FormElement('textarea');
		$this->element->valueInside();
	}
	
}

?>