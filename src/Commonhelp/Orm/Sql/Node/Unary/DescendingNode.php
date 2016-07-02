<?php

namespace Commonhelp\Orm\Sql\Node\Unary;

use Commonhelp\Orm\Sql\Node\UnaryNode;

class DescendingNode extends UnaryNode{
	
	public function reverse(){
		return new AscendingNode($this['node']);
	}
	
}
