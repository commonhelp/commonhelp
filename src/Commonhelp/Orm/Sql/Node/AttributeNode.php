<?php

namespace Commonhelp\Orm\Sql\Node;

use Commonhelp\Orm\Sql\Sql;

class AttributeNode extends LitteralNode{
	
	protected $relation;
	
	public function __construct($value, Sql $relation){
		parent::__construct($value);
		
		$this->relation = $relation;
	}
	
	public function getRelation(){
		return $this->relation;
	}
	
}
