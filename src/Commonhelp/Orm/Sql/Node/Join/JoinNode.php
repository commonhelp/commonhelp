<?php

namespace Commonhelp\Orm\Sql;

abstract class JoinNode extends BinaryNode{
	
	public function __construct(Sql $relation, $constraint){
		$table = new LitteralNode($relation->getTable());
		parent::__construct($table, $constraint);
	}
	
}
