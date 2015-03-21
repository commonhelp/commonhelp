<?php

namespace Commonhelp\Util\Expression\Context;
use Commonhelp\Util\Expression\Boolean\BooleanContext;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Boolean\TerminalExpression;
use Commonhelp\Util\Expression\Boolean\NonTerminalExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;


class FilterContext extends Context{
	
	protected $dictonary = array('&', '|', '!', '=', '~=', '<=', '>=', '*');
	
	public function parse(Expression $exprRoot){
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