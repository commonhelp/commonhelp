<?php

namespace Commonhelp\Form;

class Textarea extends FormBuilder{
	
	public function __construct(){
		$this->element = new FormElement('textarea');
		$this->element->valueInside();
	}
	
}

?>