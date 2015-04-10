<?php

namespace Commonhelp\Orm\Sql;

class SqliteVisitor extends SqlVisitor{
	
	public function visitSelect(SelectNode $n){
		if(isset($n['offset']) && !isset($n['limit'])){
			$n['limit'] = new LimitNode(-1);
		}
		return parent::visitSelect($n);
	}
}
