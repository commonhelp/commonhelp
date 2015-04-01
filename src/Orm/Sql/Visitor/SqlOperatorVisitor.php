<?php

namespace Commonhelp\Orm\Sql;
use Commonhelp\Util\Expression\Operator\OperatorVisitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Operator\SymbolExpression;
use Commonhelp\Util\Expression\Operator\LitteralExpression;

class SqlOperatorVisitor extends Visitor{
	
	protected $dictionary = array('=', '<', '<=', '>', '>=', '<>');
	
	public function __construct(){
		parent::__construct(false);
	}
	
	public function visit(Expression $e){
		print get_class($e).PHP_EOL;
	}
	
	public function process(Expression $e){
		if($e instanceof SymbolExpression){
			if(!in_array($e->getValue(), $this->dictionary)){
				throw new \RuntimeException("No match symbol");
			}
			return $e->getValue();
		}else if($e instanceof LitteralExpression){
			return $e->getValue();
		}
	}
	
}