<?php
namespace Commonhelp\Util\Expression;

abstract class PreOrderVisitor extends Visitor{
	
	protected $symbol;
	
	public function getSymbol(){
		return $this->symbol;
	}
	
	public function visit(Expression $e){
		$this->expression .= $this->parenthesize($e, "(");
		$this->expression .= "{$this->process($e)}";
		if(null !== $e->getLeft()){
			$e->getLeft()->accept($this);
		}
		if(!($e instanceof UnaryExpression)){
			if(null !== $e->getRight()){
				$e->getRight()->accept($this);
			}
		}
		$this->expression .= $this->parenthesize($e, ")");
	}
	
}

