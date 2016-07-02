<?php

namespace Commonhelp\Orm\Sql\Node;


class DeleteNode extends Node {
	
	public function __construct() {
		$this->value = 'DELETE';
	}
	
}
