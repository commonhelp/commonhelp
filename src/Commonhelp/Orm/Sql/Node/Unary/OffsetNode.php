<?php

namespace Commonhelp\Orm\Sql\Node\Unary;
use Commonhelp\Orm\Sql\Node\UnaryNode;
use Commonhelp\Orm\Exception\SqlException;

class OffsetNode extends UnaryNode{
	
	public function __construct($amount) {
		if(!is_int($amount)){
			throw new SqlException('Offset must be int');
		}
		$this->value = $amount;
	}
	
}
