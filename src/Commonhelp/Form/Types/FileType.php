<?php
namespace Commonhelp\Form\Types;

class FileType extends AbstractType{
	
	public function __construct(){
		$this->acceptedTags('input');
		$this->template = 'file';
	}
	
	public function getName(){
		return 'file';
	}
	
}