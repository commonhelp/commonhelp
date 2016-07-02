<?php
namespace Commonhelp\Form\Types;

class ButtonType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input', 'button');
		$this->template = 'button';
	}
	
	public function getName(){
		return 'button';
	}
	
}