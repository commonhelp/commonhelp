<?php

namespace Commonhelp\Orm\Sql;

class InsertManager extends AstManager{
	
	public function __construct(){
		$this->ast = new InsertNode();
	}
	
	public function into(Sql $table){
		$this->ast['relation'] = $table;
		return $this;
	}
	
	public function columns(AttributeNode $column){
		$this->ast['columns'][] = $column;
	}
	
	public function insert(){
		
	}
	
}

