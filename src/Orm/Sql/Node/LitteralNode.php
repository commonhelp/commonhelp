<?php

namespace Commonhelp\Orm\Sql;


class LitteralNode extends Node{
	
	public function __construct($value) {
		$this->value = $value;
	}
	
}
