<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\Exception\SqlException;

class FunctionNode extends Node{
	
	
	public function __construct($expression, LitteralNode $alias=null) {
		$this->value = $expression;
		$this['alias'] = $alias;
	}
	
	public function alias($alias){
		if($alias instanceof LitteralNode){
			$this['alias'] = $alias;
		}else{
			$this['alias'] = new LitteralNode($alias);
		}
	}
	
}
