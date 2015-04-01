<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;
use Commonhelp\Util\Expression\Expression;

class WhereNode extends Node{
	
	public function __construct($expression) {
		if(!($expression instanceof Expression)){
			throw new SqlException('Expression must be of Expression Type');
		}
		$this->value = $expression;
	}
	
}
