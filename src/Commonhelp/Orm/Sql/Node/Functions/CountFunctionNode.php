<?php

namespace Commonhelp\Orm\Sql\Node\Functions;


use Commonhelp\Orm\Sql\Node\FunctionNode;
use Commonhelp\Orm\Sql\Node\LitteralNode;
use Commonhelp\Orm\Exception\SqlException;

class CountFunctionNode extends FunctionNode{
	
	protected $distinct;
	
	public function __construct($expression, $distinct = false, LitteralNode $alias=null) {
		parent::__construct($expression, $alias);
		$this->distinct = $distinct;
	}
	
	public function isDistinct(){
		return $this->distinct;
	}
	
}
