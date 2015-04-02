<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;

class SqlVisitor extends Visitor{
	
	public function visit(Expression $e){
		$visiting = 'visit'.str_replace('Node', '', $e);
		
		return $this->$visiting($e);
	}
	
	public function visitLitteral(Node $n){
		return $this->process($n);
	}
	
	public function visitProject(Node $ns){
		$collector = array();
		foreach($ns as $project){
			$collector[] = $project->accept($this);
		}
		
		return implode(', ', $collector);
	}
	
	public function visitWhere(Node $n){
		$expression = $this->process($n);
		if(!($expression instanceof BinaryExpression)){
			throw new SqlException('Expression must be of BinaryExpression Type');
		}
		if($expression instanceof OperatorExpression){
			$visitor = new SqlOperatorVisitor();
		}
		if($expression instanceof BooleanExpression){
			$visitor = new SqlBooleanVisitor();
		}
		
		return $expression->accept($visitor);
	}
	
	public function visitSelect(Node $n){
		$projections = '';
		if(isset($n['projections'])){
			$projections .= ' ';
			$p = $n['projections']->accept($this);
			$projections .= $p;
		}
		
		$from='';
		if(isset($n['froms'])){
			$f = $n['froms']->accept($this);
			$from = ' FROM '.$f;
		}
		
		$group = '';
		
		$where = '';
		if(isset($n['wheres'])){
			$expr = $n['wheres']->accept($this);
			$where = " WHERE {$expr}";
		}
		
		$having = '';
		
		$order = '';
		
		$limit = '';
		
		return $this->process($n).$projections.$from.$where.$group.$having.$order.$limit;
	}
	
	public function process(Expression $e){
		return $e->getValue();
	}
	
	
	
}
