<?php
namespace Commonhelp\Form\Types;

class UrlType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'input';
	}
	
	public function getName(){
		return 'url';
	}
	
}