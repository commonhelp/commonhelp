<?php

namespace Commonhelp\Orm\Sql\Node;


class UpdateNode extends Node {
	
	public function __construct() {
		$this->value = 'UPDATE ';
	}
	
}
