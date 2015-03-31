<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\ASTreeExpression;
use Commonhelp\Util\Expression\Visitor;

class Node extends ASTreeExpression{
	
	protected $value;
	
	public function getValue(){
		return $this->value;
	}
	
	public function setValue($value){
		$this->value = $value;
	}
	
	public function accept(Visitor $visitor){
		
	}
	
	
}
