<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\BTreeExpression;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Expression;

class AndExpression extends NonTerminalExpression implements BinaryExpression{
	
	
	public function __construct(Expression $left, Expression $right){
		$this->left = $left;
		$this->right = $right;
		$this->value = 'and';
	}
	
	public function accept(Visitor $visitor){
		return $visitor->visit($this);
	}
	
}