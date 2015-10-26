<?php

namespace Commonhelp\Orm\Sql\Node\Binary;

use Commonhelp\Orm\Sql\Node\LitteralNode;
use Commonhelp\Orm\Sql\Node\BinaryNode;

class AsNode extends BinaryNode{
	
	public function __construct(LitteralNode $left, LitteralNode $right){
		parent::__construct($left, $right);
	}
	
}
