<?php

namespace Commonhelp\Ldap;
use Commonhelp\Util\Expression\Boolean\BooleanContext;
use Commonhelp\Ldap\Filters\FilterExpression;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Boolean\NonTerminalExpression;
use Commonhelp\Ldap\Exception\LdapException;

class Filter extends BooleanContext{
	
	protected $dictonary = array('&', '|', '!');
	
	public function parse(Expression $exprRoot){
		$this->parsed = '';
		$this->preOrderBT($exprRoot, $this->parsed);
		$this->parsed = preg_replace('/\s+/', '',  $this->parsed);
		return $this->parsed;
	}
	
	public function toString($e){
		if($e instanceof FilterExpression){
			return "({$e->getValue()})";
		}else if($e instanceof NonTerminalExpression){
			return $this->getSymbol();
		}
	}
	
	public function setSymbol($symbol){
		if(!in_array($symbol, $this->dictonary)){
			throw new LdapException("Symbol {$symbol} not valid");
		}
	
		$this->symbol = $symbol;
	}
	
	public function setSymbolByMap($map, Expression $e){
		if(!in_array($map, $this->dictionaryMap)){
			throw new LdapException("Map symbol {$symbol} not correspondig to a real symbol");
		}
		$key = array_search($map, $this->dictionaryMap);
		$this->symbol = $this->dictonary[$key];
	}
}