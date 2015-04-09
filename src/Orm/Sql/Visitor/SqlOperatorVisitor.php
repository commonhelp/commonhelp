<?php

namespace Commonhelp\Orm\Sql;
use Commonhelp\Util\Expression\Operator\OperatorVisitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\Operator\SymbolExpression;


class SqlOperatorVisitor extends OperatorVisitor{
	
	protected $dictionary = array('=', '<', '<=', '>', '>=', '<>');
	
	public function __construct(){
		parent::__construct(false);
	}
	
	
	public function process(Expression $e){
		if($e instanceof SymbolExpression){
			if(!array_key_exists($e->getValue(), $this->dictionary)){
				throw new SqlException("No match symbol in sql dictionary");
			}
			return $this->dictionary[$e->getValue()];
		}else if($e instanceof Node){
			$v = new SqlVisitor(); // could create problems with INSERT,UPDATE and DELETE
			return $e->accept($v);
		}
	}
	
}