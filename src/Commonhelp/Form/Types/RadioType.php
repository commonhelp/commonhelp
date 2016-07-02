<?php
namespace Commonhelp\Form\Types;

class RadioType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'choiche';
	}
	
	public function getName(){
		return 'radio';
	}
	
}