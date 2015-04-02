<?php
namespace Commonhelp\Util\Expression;

use Commonhelp\Util\Collections\ArrayCollection;
use Commonhelp\Util\Expression\Boolean\OrExpression;
use Commonhelp\Util\Expression\Boolean\AndExpression;
use Commonhelp\Util\Expression\Boolean\NotExpression;

use ArrayAccess;
use IteratorAggregate;

abstract class ASTreeExpression implements Expression, ArrayAccess, IteratorAggregate{
	
	protected $expressions;
	
	public function __construct(){
		$this->expressions = new ArrayCollection();
	}
	
	abstract function accept(Visitor $visitor);
	
	public function offsetExists($offset) {
		return isset($this->expressions[$offset]);
	}
	
	public function offsetGet($offset) {
		return isset($this->expressions[$offset]) ? $this->expressions[$offset] : null;;
	}
	
	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
            $this->expressions[] = $value;
        } else {
            $this->expressions[$offset] = $value;
        }
	}
	
	public function offsetUnset($offset) {
		unset($this->expressions[$offset]);;
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
	
	public function getIterator(){
		return $this->expressions->getIterator();
	}
	
	
}

