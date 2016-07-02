<?php
namespace Commonhelp\Form\Types;

class DateType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'datetime';
	}
	
	public function getName(){
		return 'date';
	}
	
}