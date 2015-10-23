<?php

namespace Commonhelp\Orm\Sql\Node\Unary;

use Commonhelp\Orm\Sql\Node\UnaryNode;
use Commonhelp\Util\Expression\Expression;
class OnNode extends UnaryNode{
	
	public function __construct(Expression $node){
		parent::__construct($node);
	}
	
}
