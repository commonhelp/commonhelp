<?php

namespace Commonhelp\Orm\Sql;


class UpdateNode extends Node {
	
	public function __construct() {
		$this->value = 'UPDATE';
	}
	
}
