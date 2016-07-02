<?php
namespace Commonhelp\Form\Types;

class PasswordType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'input';
	}
	
	public function getName(){
		return 'password';
	}
	
}