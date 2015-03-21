<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Context;

class OrExpression extends NonTerminalExpression{
	
	public function __construct(BooleanExpression $left, BooleanExpression $right){
		$this->left = $left;
		$this->right = $right;
	}
	
	public function stringfy(Context $context){
		$context->setSymbolByMap('or', $this);
		return $context->toString($this);
	}
	
}