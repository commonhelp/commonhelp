<?php

namespace Commonhelp\Ldap\Filters;
use Commonhelp\Util\Expression\BTreeExpression;
use Commonhelp\Util\Expression\Context;

abstract class AsbtractFilterExpression extends BTreeExpression{
	
	public function interpret(Context $context) {
		throw new \RuntimeException('Interpreter not available in Boolean Context');
	}
	
}

