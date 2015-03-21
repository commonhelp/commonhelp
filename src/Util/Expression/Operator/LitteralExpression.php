<?php

namespace Commonhelp\Util\Expression\Operator;
use Commonhelp\Util\Expression\Context;

class LitteralExpression extends OperatorExpression{
	
	protected $litteral;
	
	public function __construct($litteral){
		$this->litteral = $litteral;
	}
	
	public function stringfy(Context $context){
		return $this->litteral;
	}
	
}