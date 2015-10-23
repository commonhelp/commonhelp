<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Expression;

class SymbolExpression extends OperatorExpression implements BinaryExpression{
	
	
	public function __construct(Expression $left, Expression $right, $symbol){
		$this->left = $left;
		$this->right = $right;
		$this->value = $symbol;
	}
	
	public function accept(Visitor $visitor) {
		return $visitor->visit($this);
	}
	
}