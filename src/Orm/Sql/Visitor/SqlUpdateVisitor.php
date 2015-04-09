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
		if(!isset($n['orders']) && !isset($n['limit'])){
			$wheres = $n['wheres'];
		}else{
			$wheres = new InNode($n['key'], $this->buildSubSelect($n['key'], $n));
		}
		$table = '';
		if(isset($n['relation'])){
			$table .= $n['relation']->getRelation();
		}
		
		$values = '';
		if(isset($n['values'])){
			$vals = array();
			foreach($n['values'] as $value){
				$opVisit = new SqlOperatorVisitor();
				$vals[] = $value->accept($opVisit);
			}
			$values = " SET ".implode(', ', $vals);
		}
		
		$where = '';
		if(isset($n['wheres'])){
			$expr = $n['wheres']->accept($this);
			$where = $expr;
		}
		
		return $this->process($n).$table.$values.$where;
	}
	
	protected function buildSubSelect($key, UpdateNode $n){
		$stmt = new SelectNode();
		$core = $stmt['core']->current();
		$core['source']['left'] = new LitteralNode($n['relation']->getTable());
		$core['projections'] = new ProjectNode();
		$core['projections'][] = $key;
		$core['wheres'] = $n['wheres'];
		$stmt['limit'] = $n['limit'];
		$stmt['orders'] = $n['orders'];
		
		return $stmt;
	}
	
}
