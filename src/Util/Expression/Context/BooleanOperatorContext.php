<?php

namespace Commonhelp\Util\Expression\Context;
use Commonhelp\Util\Expression\Operator\OperatorContext;
use Commonhelp\Util\Expression\Expression;

class BooleanOperatorContext extends OperatorContext{
	
	protected $dictonary = array('==', '<', '<=', '>', '>=', '!=', '<>', '===', '!==');
	
	
	public function parse(Expression $e){
		return $e->stringfy($this);
	}
	
	public function toString($e){
	}
	
	public function setSymbol($symbol){
		if(!in_array($symbol, $this->dictonary)){
			throw new \RuntimeException("Symbol {$symbol} not valid");
		}
		
		$this->symbol = $symbol;
	}
	
}