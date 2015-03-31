<?php

namespace Commonhelp\Util\Expression\Operator;

use Commonhelp\Util\Expression\InOrderVisitor;
use Commonhelp\Util\Expression\Expression;

abstract class OperatorVisitor extends InOrderVisitor{
	
	public function visit(Expression $e){
		parent::visit($e);
		
		return trim($this->toString());
	}
	
}