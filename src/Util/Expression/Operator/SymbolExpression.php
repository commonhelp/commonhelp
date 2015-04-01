<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\BinaryExpression;

class SymbolExpression extends OperatorExpression implements BinaryExpression{
	
	
	public function __construct(LitteralExpression $left, LitteralExpression $right, $symbol){
		$this->left = $left;
		$this->right = $right;
		$this->value = $symbol;
	}
	
	public function accept(Visitor $visitor) {
		return $visitor->visit($this);
	}
	
}