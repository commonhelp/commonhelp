<?php

namespace Commonhelp\Orm\Sql\Node;

use Commonhelp\Util\Expression\AstTreeExpression;
use Commonhelp\Util\Expression\Visitor;

class Node extends AstTreeExpression{
	
	const IS = 6;
	const ISNOT = 7;
	
	protected $value;
	
	public function getValue(){
		return $this->value;
	}
	
	public function setValue($value){
		$this->value = $value;
	}
	
	public function accept(Visitor $visitor){
		return $visitor->visit($this);
	}
	
	public function getLeft(){
		if($this->offsetExists('left')){
			return $this->offsetGet('left');
		}
		
		return null;
	}
	
	public function getRight(){
		if($this->offsetExists('right')){
			return $this->offsetGet('right');
		}
		
		return null;
	}
	
	
}
