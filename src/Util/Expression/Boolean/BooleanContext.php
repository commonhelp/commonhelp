<?php

namespace Commonhelp\Util\Expression\Boolean;

use Commonhelp\Util\Expression\Context;

abstract class BooleanContext extends Context{
	
	protected $precedence;
	protected $parsed;
	protected $dictionaryMap = array('and', 'or', 'not');
	
	public function __construct($precedence=true){
		$this->precedence = $precedence;
	}
	
	public function isPrecedence(){
		return $this->precedence;
	}
	
	protected function inOrderBT($e, &$inorder = ''){
		if(null === $e){
			return;
		}
		$inorder .= $this->parenthesize($e, "(");
		$this->inOrderBT($e->getLeft(), $inorder);
		$inorder .= " {$e->stringfy($this)} ";
		$this->inOrderBT($e->getRight(), $inorder);
		$inorder .= $this->parenthesize($e, ")");
	}
	
	protected function preOrderBT($e, &$preorder = ''){
		if(null === $e){
			return;
		}
		$preorder .= $this->parenthesize($e, "(");
		$preorder .= " {$e->stringfy($this)} ";
		$this->preOrderBT($e->getLeft(), $preorder);
		$this->preOrderBT($e->getRight(), $preorder);
		$preorder .= $this->parenthesize($e, ")");
	}
	
	protected function postOrderBT($e, &$postorder = ''){
		if(null === $e){
			return;
		}
		$postorder .= $this->parenthesize($e, "(");
		$this->postOrderBT($e->getLeft(), $postorder);
		$this->postOrderBT($e->getRight(), $postorder);
		$postorder .= " {$e->stringfy($this)} ";
		$postorder .= $this->parenthesize($e, ")");
	}
	
	protected function heightBT($e){
		if(null === $e){
			return -1;
		}
		
		return max($this->heightBT($e->getLeft()), $this->heightBT($e->getRight())) + 1;
	}
	
	protected function setNotation(){
		$this->notation = $notation;
	}
	
	protected function getNotation(){
		return $this->notation;
	}
	
	protected function parenthesize($e, $strP){
		if($this->precedence){
			if($e->getLeft() !== null && $e->getRight() !== null){
				return $strP;
			}
		}
		
		return null;
	}
	
	abstract function setSymbolByMap($map, BooleanExpression $e);
	
}