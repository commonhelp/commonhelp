<?php
namespace Commonhelp\Form\Types;

class SubmitType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('submit');
		$this->template = 'button';
	}
	
	public function getName(){
		return 'submit';
	}
	
}