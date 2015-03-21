<?php
namespace Commonhelp\Util\Expression;

abstract class Context{
	
	protected $symbol;
	
	public function getSymbol(){
		return $this->symbol;
	}
	
	abstract public function setSymbol($symbol);
	abstract public function parse(Expression $e);
	abstract public function toString($e);
}

