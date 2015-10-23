<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\BTreeExpression;
use Commonhelp\Util\Expression\UnaryExpression;
use Commonhelp\Util\Expression\Expression;

class NotExpression extends NonTerminalExpression implements UnaryExpression{
	
	public function __construct(Expression $expr){
		$this->left = $expr;
		$this->right = null;
		$this->value = 'not';
	}
	
	public function accept(Visitor $visitor){
		return $visitor->visit($this);
	}
	
}