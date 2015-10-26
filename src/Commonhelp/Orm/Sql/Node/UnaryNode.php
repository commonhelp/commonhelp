<?php

namespace Commonhelp\Orm\Sql\Node;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
class UnaryNode extends Node{
	
	
	public function __construct(Expression $node) {
		$this->offsetSet('node', $node);
	}
	
}
