<?php

namespace Commonhelp\Util\Expression\Boolean;

use Commonhelp\Util\Expression\InOrderVisitor;
use Commonhelp\Util\Expression\Expression;

abstract class BooleanVisitor extends InOrderVisitor{
	
	protected $dictionaryMap = array('and', 'or', 'not');
	
	public function visit(Expression $e){
		parent::visit($e);
		
		return $this->toString();
	}
	
}