<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;

class SqlUpdateVisitor extends SqlVisitor{
	
	public function visitUpdate(UpdateNode $n){
		
		$table = '';
		if(isset($n['relation'])){
			$table .= $n['relation']->getRelation();
		}
		
		$values = '';
		if(isset($n['values'])){
			$values = " SET ";
			print_r($n['values']);
			$values .= $n['values']->accept($this);
		}
		
		return $this->process($n).$table.$values;
	}
	
}
