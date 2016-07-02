<?php
namespace Commonhelp\Form\Types;

class TelType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'phone';
	}
	
	public function getName(){
		return 'tel';
	}
	
}