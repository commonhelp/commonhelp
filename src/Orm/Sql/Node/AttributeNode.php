<?php

namespace Commonhelp\Orm\Sql;


class AttributeNode extends LitteralNode{
	
	protected $relation;
	
	public function __construct($value, $relation){
		parent::__construct($value);
		
		$this->relation = $relation;
	}
	
}
