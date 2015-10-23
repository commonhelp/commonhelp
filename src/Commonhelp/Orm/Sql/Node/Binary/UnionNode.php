<?php

namespace Commonhelp\Orm\Sql;

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
