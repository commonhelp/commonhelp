<?php
namespace Commonhelp\Form\Types;

class EmailType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'email';
	}
	
	public function getName(){
		return 'email';
	}
	
}