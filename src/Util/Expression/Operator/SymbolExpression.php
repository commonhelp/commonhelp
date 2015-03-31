<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Visitor;

class SymbolExpression extends OperatorExpression{
	
	
	public function __construct(LitteralExpression $left, LitteralExpression $right, $symbol){
		$this->left = $left;
		$this->right = $right;
		$this->value = $symbol;
	}
	
	public function accept(Visitor $visitor) {
		return $visitor->visit($this);
	}
	
}