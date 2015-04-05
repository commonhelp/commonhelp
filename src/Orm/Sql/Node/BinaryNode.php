<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
class BinaryNode extends Node{
	
	
	public function __construct(Node $left=null, Node $right=null) {
		$this->offsetSet('left', $left);
		$this->offsetSet('right', $right);
	}
	
}
