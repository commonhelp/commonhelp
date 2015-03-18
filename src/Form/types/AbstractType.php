<?php
namespace Commonhelp\Form;

abstract class AbstractType implements FormType{
	
	protected $acceptedTag = array();
	
	public function attributes(){
		return array();
	}
	
	public function getAcceptedTag() {
		return $this->acceptedTag;
	}
	
}