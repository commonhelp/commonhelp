<?php

namespace Commonhelp\Orm\Sql;



use Commonhelp\Util\Expression\Expression;
class OnNode extends UnaryNode{
	
	public function __construct(Expression $node){
		parent::__construct($node);
	}
	
}
