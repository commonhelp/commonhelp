<?php

namespace Commonhelp\Util\Expression\Context;
use Commonhelp\Util\Expression\Operator\OperatorVisitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Operator\SymbolExpression;
use Commonhelp\Util\Expression\Operator\LitteralExpression;

class BooleanOperatorVisitor extends OperatorVisitor{
	
	protected $dictionary = array('==', '<', '<=', '>', '>=', '!=', '<>', '===', '!==');
	
	
	public function process(Expression $e){
		if($e instanceof SymbolExpression){
			if(!array_key_exists($e->getValue(), $this->dictionary)){
				throw new \RuntimeException("No match symbol");
			}
			return $this->dictionary[$e->getValue()];
		}else if($e instanceof LitteralExpression){
			return $e->getValue();
		}
	}
	
}