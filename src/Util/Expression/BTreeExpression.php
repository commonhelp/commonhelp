<?php
namespace Commonhelp\Util\Expression;

abstract class BTreeExpression implements Expression{
	protected $left;
	protected $right;
	
	protected $value;
	
	abstract function accept(Visitor $visitor);
	
	public function getLeft(){
		return $this->left;
	}
	
	public function getRight(){
		return $this->right;
	}
	
	public function getValue(){
		return $this->value;
	}
	
	public function setValue($value){
		$this->value = $value;
	}
}

