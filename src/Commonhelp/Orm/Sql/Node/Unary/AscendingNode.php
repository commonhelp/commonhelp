<?php

namespace Commonhelp\Orm\Sql\Node\Unary;

use Commonhelp\Orm\Sql\Node\UnaryNode;


class AscendingNode extends UnaryNode{
	
	
	public function reverse(){
		return new DescendingNode($this['node']);
	}
	
}
