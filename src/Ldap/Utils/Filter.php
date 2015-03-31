<?php

namespace Commonhelp\Ldap;
use Commonhelp\Util\Expression\PreOrderVisitor;
use Commonhelp\Ldap\Exception\LdapException;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Boolean\NonTerminalExpression;
use Commonhelp\Ldap\Filters\FilterExpression;

class Filter extends PreOrderVisitor{
	
	protected $dictonary = array('&', '|', '!');
	protected $dictionaryMap = array('and', 'or', 'not');
	
	public function visit(Expression $e){
		parent::visit($e);
		
		return $this->toString();
	}
	
	public function process(Expression $e){
		if($e instanceof FilterExpression){
			return "({$e->getValue()})";
		}else if($e instanceof NonTerminalExpression){
			if(!in_array($e->getValue(), $this->dictionaryMap)){
				throw new LdapException("No match symbol for ldap filtering");
			}
			$key = array_search($e->getValue(), $this->dictionaryMap);
			return $this->dictonary[$key];

		}
	}
	
}