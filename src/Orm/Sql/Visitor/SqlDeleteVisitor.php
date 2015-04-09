<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;

class SqlDeleteVisitor extends SqlVisitor{
	
	public function visitDelete(DeleteNode $n){
		$relation = " FROM ".$n['relation']->accept($this);
		
		$where="";
		if(isset($n['wheres'])){
			$expr = $n['wheres']->accept($this);
			$where = $expr;
		}
		
		$limit="";
		if(isset($n['limit'])){
			$limit = $n['limit']->accept($this);
		}
		
		return $this->process($n).$relation.$where.$limit;
	}
	
}
