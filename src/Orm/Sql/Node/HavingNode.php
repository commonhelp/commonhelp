<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;

class HavingNode extends Node{
	
	public function __construct($expression) {
		if(!($expression instanceof BooleanExpression)){
			throw new SqlException('Expression must be of BooleanExpression Type');
		}
		$this->value = $expression;
	}
	
}
