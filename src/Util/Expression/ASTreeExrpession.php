<?php
namespace Commonhelp\Util\Expression;

use Commonhelp\Util\Collections\ArrayCollection;

abstract class ASTreeExpression implements Expression{
	
	public function __construct(){
		$this->expressions = new ArrayCollection();
	}
	
	abstract function interpret(Context $context);
	abstract function stringfy(Context $context);
	
	
}

