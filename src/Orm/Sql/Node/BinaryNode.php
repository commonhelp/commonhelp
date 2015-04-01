<?php

namespace Commonhelp\Orm\Sql;

class BinaryNode extends Node{
	
	protected $left;
	protected $right;
	
	public function __construct(LitteralNode $left, LitteralNode $right) {
		$this->offsetSet('left', $left);
		$this->offsetSet('right', $right);
	}
	
}
