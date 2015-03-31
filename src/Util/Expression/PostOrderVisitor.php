<?php
namespace Commonhelp\Util\Expression;

abstract class PostOrderVisitor extends Visitor{
	
	protected $symbol;
	
	public function getSymbol(){
		return $this->symbol;
	}
	
	public function visit(Expression $e){
		$this->expression .= $this->parenthesize($e, "(");
		if(null !== $e->getLeft()){
			$e->getLeft()->accept($this);
		}
		if(!($e instanceof UnaryExpression)){
			if(null !== $e->getRight()){
				$e->getRight()->accept($this);
			}
		}
		$this->expression .= "{$this->process($e)}";
		$this->expression .= $this->parenthesize($e, ")");
	}
}

