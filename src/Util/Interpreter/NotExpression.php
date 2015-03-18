<?php

namespace Commonhelp\Util\Interpreter;

class NotExpression implements Expression{
	
	protected $expr;
	
	public function __construct(Expression $expr){
		$this->expr = $expr;
	}
	
	public function interpret(){
		
	}
	
}