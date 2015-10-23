<?php

namespace Commonhelp\Orm\Sql\Node\Join;
use Commonhelp\Orm\Sql\Node\JoinNode;

class JoinSourceNode extends BinaryNode{
	
	public function __construct($single, $joinOp){
		parent::__construct($single, $joinOp);
	}
	
}
