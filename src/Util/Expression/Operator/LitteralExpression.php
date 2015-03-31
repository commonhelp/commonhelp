<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Visitor;

class LitteralExpression extends OperatorExpression{
	

	public function __construct($litteral){
		$this->value = $litteral;
	}
	
	public function accept(Visitor $visitor){
		return $visitor->visit($this);
	}
	
}