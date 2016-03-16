<?php
namespace Commonhelp\Form\Types;

class SearchType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags = array('input');
		$this->template = 'input';
	}
	
	public function getName(){
		return 'search';
	}
	
}