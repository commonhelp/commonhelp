<?php

namespace Commonhelp\Orm\Sql;



class SelectNode extends Node{
	
	public function __construct() {
		$this->value = 'SELECT';
	}
}
