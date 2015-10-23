<?php

namespace Commonhelp\Orm\Sql;

class JoinSourceNode extends BinaryNode{
	
	public function __construct($single, $joinOp){
		parent::__construct($single, $joinOp);
	}
	
}
