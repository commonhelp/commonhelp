<?php

namespace Commonhelp\Orm\Sql\Visitor;
use Commonhelp\Util\Expression\Operator\OperatorVisitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\Operator\SymbolExpression;
use Commonhelp\Orm\Sql\Node\Node;

class SqlOperatorVisitor extends OperatorVisitor{
	
	protected $dictionary = array('=', '<', '<=', '>', '>=', '<>', 'IS', 'IS NOT');
	
	protected $parentVisitor;
	
	public function __construct(SqlVisitor $parent){
		$this->parentVisitor = $parent;
		parent::__construct(false);
	}
	
	
	public function process(Expression $e){
		if($e instanceof SymbolExpression){
			if(!array_key_exists($e->getValue(), $this->dictionary)){
				throw new SqlException("No match symbol in sql dictionary");
			}
			return $this->dictionary[$e->getValue()];
		}else if($e instanceof Node){
			return $e->accept($this->parentVisitor);
		}
	}
	
}