<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\BinaryExpression;

class NotEqualExpression extends SymbolExpression implements BinaryExpression{
	
	
	public function __construct(Expression $left, Expression $right){
		parent::__construct($left, $right, OperatorVisitor::NOTEQUAL);
	}
	
}