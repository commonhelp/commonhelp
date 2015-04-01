<?php

namespace Commonhelp\Util\Expression\Operator;

use Commonhelp\Util\Expression\InOrderVisitor;
use Commonhelp\Util\Expression\Expression;

abstract class OperatorVisitor extends InOrderVisitor{
	
	const EQUAL = 0;
	const LESSTHAN = 1;
	const LESSTHANEQUAL = 2;
	const GREATERTHAN = 3;
	const GREATERTHANEQUAL = 4;
	const NOTEQUAL = 5;
	const NOTEQUALALT = 6;
	const EQUALTYPE = 7;
	const NOTEQUALTYPE = 8;


	public function visit(Expression $e){
		parent::visit($e);
		
		return trim($this->toString());
	}
	
}