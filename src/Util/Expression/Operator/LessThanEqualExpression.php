<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\BinaryExpression;

class LessThanEqualExpression extends OperatorExpression implements BinaryExpression{
	
	
	public function __construct(Expression $left, Expression $right){
		$this->left = $left;
		$this->right = $right;
	}
	
	public function accept(Visitor $visitor) {
		return $visitor->visit($this);
	}
	
}