<?php

namespace Commonhelp\Orm\Sql;

class GroupingNode extends Node{
	
	public function __construct($expression) {	
		$this->value = $expression;
	}
}
