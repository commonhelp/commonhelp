<?php
namespace Commonhelp\Form\Types;

use Commonhelp\Form\FormType;

abstract class AbstractType implements FormType{
	
	protected $acceptedTags = array();
	protected $template;
	
	public function attributes(){
		return array();
	}
	
	public function getTemplate(){
		return $this->template;
	}
	
	public function getAcceptedTags() {
		return $this->acceptedTags;
	}
	
}