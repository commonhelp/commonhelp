<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;

class SqlInsertVisitor extends SqlVisitor{
	
	
	public function visitInsert(InsertNode $n){
		$table = '';
		if(isset($n['relation'])){
			$table = $n['relation']->getRelation();
		}
		
		$columns = '';
		if(isset($n['columns'])){
			$columns = $n['columns']->accept($this);
		}
		
		$values = '';
		if(isset($n['values'])){
			$values = $n['values']->accept($this);
		}else if(isset($n['select'])){
			$values = $n['select']->toString();
		}
		
		return $this->process($n).$table.$columns.$values;
	}
	
	public function visitColumn(ColumnNode $ns){
		if(count($ns) == 0){
			return '';
		}
		$collector = array();
		foreach($ns as $n){
			$collector[] = $n->getValue();
		}
		
		return " (".implode(', ', $collector).") ";
	}
	
	public function visitValues(ValuesNode $n){
		return "VALUES (".implode(', ', $n->getValue()).")";
	}

	
}
