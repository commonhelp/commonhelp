<?php

namespace Commonhelp\Form;

class Input extends FormBuilder{
	
	private $tag = 'input';
	
	public function __construct(FormType $type){
		$this->element = new FormElement('input', true);
		$this->element->setType($type);
	}
	
	public function setType(FileType $type){
		$this->element->setType($type);
	}
	
}

?>