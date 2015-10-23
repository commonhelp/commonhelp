<?php

namespace Commonhelp\Orm\Sql\Node\Join;

use Commonhelp\Orm\Sql\Node\JoinNode;
use Commonhelp\Orm\Sql\Sql;

abstract class JoinNode extends BinaryNode{
	
	public function __construct(Sql $relation, $constraint){
		$table = new LitteralNode($relation->getTable());
		parent::__construct($table, $constraint);
	}
	
}
