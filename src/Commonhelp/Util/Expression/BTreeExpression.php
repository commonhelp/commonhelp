<?php
namespace Commonhelp\Util\Expression;
use Commonhelp\Util\Expression\Boolean\OrExpression;
use Commonhelp\Util\Expression\Boolean\AndExpression;
use Commonhelp\Util\Expression\Boolean\NotExpression;

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
	
	public function otherwise(Expression $right){
		return new OrExpression($this, $right);
	}
	
	public function also(Expression $right){
		return new AndExpression($this, $right);
	}
	
	public function negate(){
		return new NotExpression($this);
	}
	
	public function __toString() { 
		$class = explode('\\', get_class($this)); 
		return end($class); 
	} 
}

