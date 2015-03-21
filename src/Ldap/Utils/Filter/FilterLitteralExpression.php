<?php

namespace Commonhelp\Ldap\Filters;
use Commonhelp\Util\Expression\Context;

class FilterLitteralExpression extends AbstractFilterExpression{
	
	public function __construct($litteral){
		$this->value = $litteral;
		$this->left = null;
		$this->right = null;
		
	}
	
	public function stringfy(Context $context){
		return $context->toString($this);
	}
	
}

