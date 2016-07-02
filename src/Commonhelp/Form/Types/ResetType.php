<?php
namespace Commonhelp\Form\Types;

class ResetType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input', 'button');
		$this->template = 'button';
	}
	
	public function getName(){
		return 'reset';
	}
	
}