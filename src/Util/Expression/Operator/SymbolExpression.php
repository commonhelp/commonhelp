<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Context;

class SymbolExpression extends OperatorExpression{
	
	protected $leftLitteral;
	protected $rightLitteral;
	
	public function __construct(LitteralExpression $left, LitteralExpression $right){
		$this->leftLitteral = $left;
		$this->rightLitteral = $right;
	}
	
	public function stringfy(Context $context) {
		$expression = $this->leftLitteral->stringfy($context).' '.$context->getSymbol().' '.$this->rightLitteral->stringfy($context);
		return $expression;
	}
	
}