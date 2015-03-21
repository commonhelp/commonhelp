<?php

namespace Commonhelp\Util\Expression\Boolean;

use Commonhelp\Util\Expression\BTreeExpression;
use Commonhelp\Util\Expression\Context;

abstract class BooleanExpression extends BTreeExpression{
	
	public function interpret(Context $context) {
		throw new \RuntimeException('Interpreter not available in Boolean Context');
	}
}