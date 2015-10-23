<?php

namespace Commonhelp\Orm\Sql\Node\Binary;

use Commonhelp\Orm\Sql\Node\BinaryNode;

class UnionNode extends BinaryNode{
	protected $op;
	
	public function __construct($left, $right, $op){
		parent::__construct($left, $right);
		$this->op = $op;
	}
	
	public function getOp(){
		return $this->op;
	}
}
