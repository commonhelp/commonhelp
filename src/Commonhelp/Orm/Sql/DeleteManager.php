<?php

namespace Commonhelp\Orm\Sql;

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


