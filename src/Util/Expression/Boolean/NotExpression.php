<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Context;

class NotExpression extends NonTerminalExpression{
	
	public function __construct(BooleanExpression $expr){
		$this->left = $expr;
		$this->right = null;
		$this->value = null;
	}
	
	public function stringfy(Context $context){
		$context->setSymbolByMap('not', $this);
		return $context->toString($this);
	}
	
}