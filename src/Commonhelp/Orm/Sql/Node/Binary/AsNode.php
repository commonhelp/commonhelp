<?php

namespace Commonhelp\Orm\Sql\Node\Binary;

use Commonhelp\Orm\Sql\Node\LitteralNode;

class AsNode extends BinaryNode{
	
	public function __construct(LitteralNode $left, LitteralNode $right){
		parent::__construct($left, $right);
	}
	
}
