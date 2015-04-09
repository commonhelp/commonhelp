<?php

namespace Commonhelp\Orm\Sql;

class DeleteManager extends AstManager{

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
	
	public function where($expression){
		$this->ast['wheres'] = new WhereNode($expression);
		
		return $this;
	}
}


