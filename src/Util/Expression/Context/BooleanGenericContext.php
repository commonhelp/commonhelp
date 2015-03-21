<?php

namespace Commonhelp\Util\Expression\Context;
use Commonhelp\Util\Expression\Boolean\BooleanContext;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Boolean\TerminalExpression;
use Commonhelp\Util\Expression\Boolean\NonTerminalExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;


class BooleanGenericContext extends BooleanContext{
	
	protected $dictonary = array('&&', '||', '!');
	
	protected $maxHeight;
	
	public function parse(Expression $exprRoot){
		$this->parsed = '';
		$this->inOrderBT($exprRoot, $this->parsed);
		
		return $this->parsed;
	}
	
	public function toString($e){
		if($e instanceof TerminalExpression){
			return $e->getValue();
		}else if($e instanceof NonTerminalExpression){
			return $this->getSymbol();
		}
	}
	
	public function setSymbol($symbol){
		if(!in_array($symbol, $this->dictonary)){
			throw new \RuntimeException("Symbol {$symbol} not valid");
		}
		
		$this->symbol = $symbol;
	}
	
	public function setSymbolByMap($map, BooleanExpression $e){
		if(!in_array($map, $this->dictionaryMap)){
			throw new \RuntimeException("Map symbol {$symbol} not correspondig to a real symbol");
		}
		$key = array_search($map, $this->dictionaryMap);
		$this->symbol = $this->dictonary[$key];
	}
}