<?php
namespace Commonhelp\Form\Types;

class TimeType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'datetime';
	}
	
	public function getName(){
		return 'time';
	}
	
}