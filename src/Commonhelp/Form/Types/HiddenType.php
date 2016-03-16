<?php
namespace Commonhelp\Form\Types;

class HiddenType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'hidden';
	}
	
	public function getName(){
		return 'hidden';
	}
	
}