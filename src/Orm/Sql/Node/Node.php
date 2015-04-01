<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\ASTreeExpression;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Boolean\OrExpression;
use Commonhelp\Util\Expression\Boolean\AndExpression;

class Node extends ASTreeExpression{
	
	protected $value;
	
	public function getValue(){
		return $this->value;
	}
	
	public function setValue($value){
		$this->value = $value;
	}
	
	public function otherwise(Node $right){
		return new GroupingNode(new OrExpression($this, $right));
	}
	
	public function also(Node $right){
		return new GroupingNode(new AndExpression($this, $right));
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
