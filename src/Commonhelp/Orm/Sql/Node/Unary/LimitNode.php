<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\Exception\SqlException;

class LimitNode extends UnaryNode{
	
	public function __construct($amount) {
		if(!is_int($amount)){
			throw new SqlException('Limit must be int');
		}
		$this->value = $amount;
	}
	
}
