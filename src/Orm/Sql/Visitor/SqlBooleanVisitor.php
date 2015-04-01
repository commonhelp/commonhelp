<?php

namespace Commonhelp\Orm\Sql;
use Commonhelp\Util\Expression\Boolean\BooleanVisitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Boolean\NonTerminalExpression;
use Commonhelp\Util\Expression\Boolean\TerminalExpression;


class SqlBooleanVisitor extends BooleanVisitor{
	
	protected $dictonary = array('AND', 'OR', 'NOT');
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function process(Expression $e){
		if($e instanceof NonTerminalExpression){
			if(!in_array($e->getValue(), $this->dictionaryMap)){
				throw new \RuntimeException("No match symbol");
			}
			$key = array_search($e->getValue(), $this->dictionaryMap);
			return $this->dictonary[$key];
		}else if($e instanceof TerminalExpression){
			return $e->getValue();
		}else if($e instanceof GroupingNode){
			return $e->getValue();
		}
	}
}