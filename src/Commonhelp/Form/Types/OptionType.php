<?php
namespace Commonhelp\Form\Types;

class OptionType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('option');
		$this->template = 'option';
	}
	
	public function getName(){
		return 'option';
	}
	
}