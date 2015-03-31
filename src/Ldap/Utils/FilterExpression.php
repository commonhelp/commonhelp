<?php

namespace Commonhelp\Ldap\Filters;
use Commonhelp\Util\Expression\Context;
use Commonhelp\Util\Expression\BTreeExpression;


class FilterExpression extends BTreeExpression{
	public function __construct($litteral){
		$this->value = $litteral;
		$this->left = null;
		$this->right = null;
		
	}
	public function interpret(Context $context) {
		throw new \RuntimeException('Interpreter not available in Ldap Filters Context');
	}
	
	public function stringfy(Context $context){
		return $context->toString($this);
	}
	
}

