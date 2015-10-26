<?php

namespace Commonhelp\Orm\Sql\Node;


class InsertNode extends Node {
	
	public function __construct() {
		$this->value = 'INSERT INTO ';
		$this['columns'] = new ColumnNode();
	}
	
}
