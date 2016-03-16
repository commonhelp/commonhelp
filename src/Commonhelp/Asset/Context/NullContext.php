<?php
namespace  Commonhelp\Asset\Context;

class NullContext implements ContextInterface{
	
	public function getBasePath(){
		return '';
	}
	
	public function isSecure(){
		return false;
	}
	
}