<?php

namespace Commonhelp\Orm\Sql;


class OffsetNode extends Node{
	
	public function __construct($amount) {
		if(!is_int($amount)){
			throw new SqlException('Offset must be int');
		}
		$this->value = $amount;
	}
	
}
