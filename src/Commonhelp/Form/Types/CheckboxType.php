<?php
namespace Commonhelp\Form\Types;

class CheckboxType extends AbstractType{
	
	private $isChecked = false;
	
	
	public function __construct(){
		$this->acceptedTag = array('input');
	}
	
	public function getName(){
		return 'checkbox';
	}
	
	public function setChecked(){
		$this->isChecked = true;
	}
	
	public function isChecked(){
		return $this->isChecked;
	}
	
}