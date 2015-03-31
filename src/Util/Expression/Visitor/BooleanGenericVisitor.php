<?php

namespace Commonhelp\Util\Expression\Context;
use Commonhelp\Util\Expression\Boolean\BooleanVisitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Boolean\NonTerminalExpression;
use Commonhelp\Util\Expression\Boolean\TerminalExpression;


class BooleanGenericVisitor extends BooleanVisitor{
	
	protected $dictonary = array('&&', '||', '!');
	
	
	public function process(Expression $e){
		if($e instanceof NonTerminalExpression){
			if(!in_array($e->getValue(), $this->dictionaryMap)){
				throw new \RuntimeException("No match symbol");
			}
			$key = array_search($e->getValue(), $this->dictionaryMap);
			return $this->dictonary[$key];
		}else if($e instanceof TerminalExpression){
			return $e->getValue();
		}
	}
}