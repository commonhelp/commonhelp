<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Operator\OperatorContext;
use Commonhelp\Util\Expression\Visitor;

class VariableExpression extends TerminalExpression{
	
	public function __construct(OperatorExpression $variable, OperatorContext $context){
		$this->value = $variable->stringfy($context);
		$this->variableContext = $context;
		$this->left = null;
		$this->right = null;
	}
	
	public function accept(Visitor $visitor){
		return $visitor->visit($this);
	}
	
}