<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;
use Commonhelp\Util\Expression\Context\BooleanGenericVisitor;

class GroupingNode extends Node{
	
	public function __construct($expression) {
		if(!($expression instanceof BinaryExpression)){
			throw new SqlException('Expression must be of BinaryExpression Type');
		}
		if($expression instanceof OperatorExpression){
			$visitor = new SqlOperatorVisitor();
		}
		if($expression instanceof BooleanExpression){
			$visitor = new SqlBooleanVisitor();
		}
		//$this->value = $visitor->visit($expression);
		$this->value = $expression;
	}
	
}
