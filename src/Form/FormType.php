<?php
namespace Commonhelp\Form;

interface FormType{
	
	public function attributes();
	
	public function getName();
	
	public function getAcceptedTag();
}