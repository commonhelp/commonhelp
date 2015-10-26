<?php

namespace Commonhelp\Orm\Sql\Node;

class GroupingNode extends Node{
	
	public function __construct($expression) {	
		$this->value = $expression;
	}
}
