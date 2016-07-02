<?php

namespace Commonhelp\Orm\Sql\Visitor;

use Commonhelp\Orm\Sql\Node\Binary\MatchingNode;
use Commonhelp\Orm\Sql\Node\Binary\NotMatchingNode;

class PgsqlVisitor extends SqlVisitor{
	
	public function visitMatching(MatchingNode $n){
		$collector = $n['left']->accept($this);
		$collecotr .= " ILIKE ";
		$collector .= $n['right']->accept($this);
		if(null !== $n->getEscape()){
			$collector .= " ESCAPE ";
			$collector .= $n->getEscape()->accept($this);
		}
	
		return $collector;
	}
	
	public function visitNotMatching(NotMatchingNode $n){
		$collector = $n['left']->accept($this);
		$collecotr .= " NOT ILIKE ";
		$collector .= $n['right']->accept($this);
		if(null !== $n->getEscape()){
			$collector .= " ESCAPE ";
			$collector .= $n->getEscape()->accept($this);
		}
	
		return $collector;
	}
	
}
