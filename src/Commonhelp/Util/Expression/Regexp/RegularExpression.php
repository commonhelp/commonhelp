<?php

namespace Commonhelp\Util\Expression\Regexp;

use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Context;

abstract class RegularExpression implements Expression{
	
	abstract function stringfy(Context $context);
	abstract function interpret(Context $context);
	
}

