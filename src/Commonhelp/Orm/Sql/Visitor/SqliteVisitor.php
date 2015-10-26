<?php

namespace Commonhelp\Orm\Sql\Visitor;

use Commonhelp\Orm\Sql\Node\SelectNode;
use Commonhelp\Orm\Sql\Node\Unary\LimitNode;

class SqliteVisitor extends SqlVisitor{
	
	public function visitSelect(SelectNode $n){
		if(isset($n['offset']) && !isset($n['limit'])){
			$n['limit'] = new LimitNode(-1);
		}
		return parent::visitSelect($n);
	}
}
