<?php

namespace Commonhelp\Orm\Sql;

abstract class JoinNode extends Node{
	
	public function __construct(Sql $relation){
		$this['relation'] = $relation;
	}
	
}
