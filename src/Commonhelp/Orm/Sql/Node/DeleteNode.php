<?php

namespace Commonhelp\Orm\Sql;


class DeleteNode extends Node {
	
	public function __construct() {
		$this->value = 'DELETE';
	}
	
}
