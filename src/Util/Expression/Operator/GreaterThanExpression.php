<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\BinaryExpression;

class GreaterThanExpression extends SymbolExpression implements BinaryExpression{
	
	
	public function __construct(Expression $left, Expression $right){
		parent::__construct($left, $right, OperatorVisitor::GREATERTHAN);
	}
	
}