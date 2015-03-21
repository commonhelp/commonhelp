<?php

namespace Commonhelp\Util\Expression\Operator;

use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Context;

abstract class OperatorExpression implements Expression{
	
	abstract function stringfy(Context $context);
	
	public function interpret(Context $context) {
		throw new \RuntimeException('Interpreter not available in Operator Context');
	}
}