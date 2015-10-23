<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\Operator\OperatorExpression;

class HavingNode extends UnaryNode{
	
	public function __construct($expression) {
		if(!($expression instanceof OperatorExpression)){
			throw new SqlException("Expression must be of OperatorExpression Type ".get_class($expression)." given");
		}
		$this->value = $expression;
	}
	
}
