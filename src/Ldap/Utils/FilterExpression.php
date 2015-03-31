<?php

namespace Commonhelp\Ldap\Filters;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\BTreeExpression;


class FilterExpression extends BTreeExpression{
	public function __construct($litteral){
		$this->value = $litteral;
		$this->left = null;
		$this->right = null;
		
	}
	
	public function accept(Visitor $visitor){
		return $visitor->visit($this);
	}
	
}

