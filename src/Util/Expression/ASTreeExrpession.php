<?php
namespace Commonhelp\Util\Expression;

use Commonhelp\Util\Collections\ArrayCollection;

abstract class ASTreeExpression implements Expression, \ArrayAccess{
	
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
	
	
}

