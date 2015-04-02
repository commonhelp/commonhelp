<?php

namespace Commonhelp\Orm\Sql;

class SelectManager extends AstManager{
	
	
	public function __construct($table = null){
		parent::__construct();
		$this->ast = new SelectNode();
		if(null !== $table){
			$this->from($table);
		}
	}
	
	public function project(){
		$this->ast['projections'] = new ProjectNode();
		$projections = func_get_args();
		foreach($projections as $projection){
			if($projection instanceof LitteralNode){
				$this->ast['projections'][] = $projection;
			}else{
				$this->ast['projections'][] = new LitteralNode($projection);
			}
		}
		
		return $this;
	}
	
	public function group(){
		$this->ast['groups'] = new Node();
		$columns = func_get_args();
		foreach($columns as $column){
			if($column instanceof LitteralNode){
				$this->ast['groups'][] = $column;
			}else{
				$this->ast['groups'][] = new LitteralNode($column);
			}
		}
		
		return $this;
	}
	
	public function order(){
		$this->ast['orders'] = new Node();
		$columns = func_get_args();
		foreach($columns as $column){
			if($column instanceof LitteralNode){
				$this->ast['orders'][] = $column;
			}else{
				$this->ast['orders'][] = new LitteralNode($column);
			}
		}
		
		return $this;
	}
	
	public function skip($amount){
		$this->ast['offset'] = new OffsetNode($amount);
		
		return $this;
	}
	
	public function take($amount){
		$this->ast['limit'] = new LimitNode($amount);
		
		return $this;
	}
	
	public function having($expression){
		$this->ast['having'] = new HavingNode($expression);
		
		return $this;
	}
	
	public function where($expression){
		$this->ast['wheres'] = new WhereNode($expression);
		
		return $this;
	}
	
	public function join($relation, $class){
		
	}
	
	public function on($expression){
		
	}


	
	public function from($table){
		if(!is_string($table)){
			$table = $table->getTable();
		}
		
		$this->ast['froms'] = new LitteralNode($table);
	}
	
}

