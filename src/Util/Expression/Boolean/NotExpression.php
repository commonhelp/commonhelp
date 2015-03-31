<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Context;
use Commonhelp\Util\Expression\BTreeExpression;

class NotExpression extends NonTerminalExpression{
	
	public function __construct(BTreeExpression $expr){
		$this->left = $expr;
		$this->right = null;
		$this->value = null;
	}
	
	public function stringfy(Context $context){
		$context->setSymbolByMap('not', $this);
		return $context->toString($this);
	}
	
}