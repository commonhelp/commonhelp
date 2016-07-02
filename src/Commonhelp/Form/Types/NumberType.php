<?php
namespace Commonhelp\Form\Types;

class NumberType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'number';
	}
	
	public function getName(){
		return 'number';
	}
	
}