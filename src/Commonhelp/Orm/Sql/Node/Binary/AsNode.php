<?php

namespace Commonhelp\Orm\Sql;

class AsNode extends BinaryNode{
	
	public function __construct(LitteralNode $left, LitteralNode $right){
		parent::__construct($left, $right);
	}
	
}
