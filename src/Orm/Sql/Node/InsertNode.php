<?php

namespace Commonhelp\Orm\Sql;


class InsertNode extends Node {
	
	public function __construct() {
		$this->value = 'INSERT';
	}
	
}
