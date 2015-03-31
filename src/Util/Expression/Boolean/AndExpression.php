<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Context;
use Commonhelp\Util\Expression\BTreeExpression;

class AndExpression extends NonTerminalExpression{
	
	
	public function __construct(BTreeExpression $left, BTreeExpression $right){
		$this->left = $left;
		$this->right = $right;
	}
	
	public function stringfy(Context $context){
		$context->setSymbolByMap('and', $this);
		return $context->toString($this);
	}
	
}