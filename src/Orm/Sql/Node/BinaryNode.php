<?php

namespace Commonhelp\Orm\Sql;

class BinaryNode extends Node{
	
	protected $left;
	protected $right;
	
	public function __construct(LitteralNode $left, LitteralNode $right) {
		$this->expressions['left'] = $this->left = $left;
		$this->expressions['right'] = $this->right = $right;
	}
	
}
