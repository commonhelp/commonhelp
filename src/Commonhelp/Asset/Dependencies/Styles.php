<?php
namespace Commonhelp\Asset\Dependencies;

class Style extends Dependencies{
	
	private $textDirection = 'ltr';
	
	
	public function getTextDirection(){
		return $this->textDirection;
	}
	
	public function setRightToLeftTextDirection(){
		$this->textDirection = 'rtl';
	}
	
	public function setLeftToRightTextDirection(){
		$this->textDirection = 'ltr';
	}
	
}