<?php
namespace Commonhelp\Form\Types;

class DatetimeType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'datetime';
	}
	
	public function getName(){
		return 'datetime';
	}
	
}