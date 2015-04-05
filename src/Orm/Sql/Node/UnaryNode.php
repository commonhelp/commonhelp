<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
class UnaryNode extends Node{
	
	
	public function __construct(Node $node) {
		$this->offsetSet('node', $node);
	}
	
}
