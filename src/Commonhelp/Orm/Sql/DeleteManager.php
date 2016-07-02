<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\Sql\Node\DeleteNode;
use Commonhelp\Orm\Sql\Node\LitteralNode;
use Commonhelp\Orm\Sql\Node\WhereNode;
use Commonhelp\Orm\Sql\Node\Unary\LimitNode;

class DeleteManager extends AstSqlManager{

	public function __construct(){
		parent::__construct();
		$this->ast = new DeleteNode();
	}
	
	public function from($table){
		if($table instanceof Sql){
			$table = $table->getTable();
		}
		
		$this->ast['relation'] = new LitteralNode($table);
		
		return $this;
	}
	
	
	public function take($amount){
		$this->ast['limit'] = new LimitNode($amount);
		
		return $this;
	}
	
	public function where($expression, $op=self::INTERSECT){
		if(is_array($expression)){
			$expression = $this->mergeExpression($expression, $op);
		}
		$this->ast['wheres'] = new WhereNode($expression);
		
		return $this;
	}
}


