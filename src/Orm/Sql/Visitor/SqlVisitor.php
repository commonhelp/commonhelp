<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;

abstract class SqlVisitor extends Visitor{
	
	public function visit(Expression $e){
		$visiting = 'visit'.str_replace('Node', '', $e);
		
		return $this->$visiting($e);
	}
	
	public function visitLitteral(LitteralNode $n){
		return $this->process($n);
	}
	
	public function visitAttribute(AttributeNode $n){
		return $n->getRelation().'.'.$n->getValue();
	}
	
	public function visitWhere(WhereNode $n){
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
	
	public function visitOn(OnNode $n){
		$collector = "ON ";
		$expression = $n['node'];
		if($expression instanceof OperatorExpression){
			$visitor = new SqlOperatorVisitor();
		}
		
		return $collector.$n['node']->accept($visitor);
	}
	

	public function process(Expression $e){
		return $e->getValue();
	}
	
	
	
}
