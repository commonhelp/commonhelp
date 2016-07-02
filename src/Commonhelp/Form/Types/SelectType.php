<?php
namespace Commonhelp\Form\Types;

class SelectType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('select');
		$this->template = 'select';
	}
	
	public function getName(){
		return 'select';
	}
	
}