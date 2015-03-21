<?php

namespace Commonhelp\Ldap\Filters;
use Commonhelp\Util\Expression\Context;

class FilterSymbolExpression extends AbstractFilterExpression{
	
	public function __construct(FilterLitteralExpression $left, FilterLitteralExpression $right){
		$this->left = $left;
		$this->right = $right;
	}
	
	public function stringfy(Context $context) {
		$expression = $this->left->stringfy($context).' '.$context->getSymbol().' '.$this->right->stringfy($context);
		return $expression;
	}
	
}

