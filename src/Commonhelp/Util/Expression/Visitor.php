<?php
namespace Commonhelp\Util\Expression;

abstract class Visitor{
	
	protected $symbol;
	protected $expression;
	protected $precedence;
	
	public function __construct($precedence=true){
		$this->precedence = $precedence;
	}
	
	public function getSymbol(){
		return $this->symbol;
	}
	
	public function isPrecedence(){
		return $this->precedence;
	}
	
	protected function parenthesize($e, $strP){
		if($this->precedence){
			if(!($e instanceof UnaryExpression)){
				if($e->getLeft() !== null && $e->getRight() !== null){
					return $strP;
				}
			}else{
				if($e->getLeft() !== null){
					return $strP;
				}
			}
		}
		
		return null;
	}
	
	public function toString(){
		return $this->expression;
	}
	
	public function __toString() {
		return $this->toString();
	}
	
	abstract public function visit(Expression $e);
	abstract public function process(Expression $e);
}

