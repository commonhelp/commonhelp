<?php

namespace Commonhelp\Orm\Sql\Node\Binary;

use Commonhelp\Orm\Sql\Node\LitteralNode;
use Commonhelp\Util\Expression\Operator\OperatorVisitor;
use Commonhelp\Util\Expression\Operator\SymbolExpression;
class NotEqualNode extends SymbolExpression{
	
	public function __construct(LitteralNode $left, LitteralNode $right){
		if($right->getValue() === null){
			$null = new LitteralNode('NULL');
			parent::__construct($left, $null, Node::ISNOT);
		}else{
			parent::__construct($left, $right, OperatorVisitor::NOTEQUAL);
		}
	}
}
