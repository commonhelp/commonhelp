<?php

namespace Commonhelp\Orm\Sql;



use Commonhelp\Util\Collections\ArrayCollection;

use ArrayAccess;
use IteratorAggregate;
use Countable;

class SelectNode extends Node implements ArrayAccess, IteratorAggregate, Countable{
	
	public function __construct() {
		$this->value = 'SELECT';
		$this['cores'] = new ArrayCollection();
		$this['cores'][] = new SelectCoreNode();
	}
	
	public function offsetExists($offset) {
		return isset($this->cores[$offset]);
	}
	
	public function offsetGet($offset) {
		return isset($this->cores[$offset]) ? $this->cores[$offset] : null;;
	}
	
	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->cores[] = $value;
		} else {
			$this->cores[$offset] = $value;
		}
	}
	
	public function offsetUnset($offset) {
		unset($this->cores[$offset]);;
	}
	
	public function getIterator(){
		return $this->cores->getIterator();
	}
	
	public function count(){
		return count($this->cores);
	}
}
