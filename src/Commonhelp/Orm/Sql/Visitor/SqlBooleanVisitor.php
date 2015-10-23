<?php

namespace Commonhelp\Orm\Sql;
use Commonhelp\Util\Expression\Boolean\BooleanVisitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Boolean\NonTerminalExpression;
use Commonhelp\Util\Expression\Boolean\TerminalExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;


class SqlBooleanVisitor extends BooleanVisitor{
	
	protected $dictonary = array('AND', 'OR', 'NOT');
	
	protected $parentVisitor;
	
	public function __construct(SqlVisitor $parent){
		parent::__construct();
		$this->parentVisitor = $parent;
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
		}else if($e instanceof OperatorExpression){
			$v = new SqlOperatorVisitor($this->parentVisitor);
			return $e->accept($v);
		}else if($e instanceof BinaryNode){
			$e->accept($this->parentVisitor);
		}
	}
}