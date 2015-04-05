<?php

namespace Commonhelp\Orm\Sql;

class SelectManager extends AstManager{
	
	protected $core;
	
	public function __construct($table = null){
		$this->visitor = new SqlSelectVisitor();
		$this->ast = new SelectNode();
		$this->core = $this->ast['cores']->last();
		if(null !== $table){
			$this->from($table);
		}
	}
	
	public function project(){
		$this->core['projections'] = new ProjectNode();
		$projections = func_get_args();
		foreach($projections as $projection){
			if($projection instanceof Node){
				$this->core['projections'][] = $projection;
			}else{
				$this->core['projections'][] = new LitteralNode($projection);
			}
		}
		
		return $this;
	}
	
	public function group(){
		$this->core['groups'] = new GroupNode();
		$columns = func_get_args();
		foreach($columns as $column){
			if($column instanceof Node){
				$this->core['groups'][] = $column;
			}else{
				$this->core['groups'][] = new LitteralNode($column);
			}
		}
		
		return $this;
	}
	
	public function order(){
		$this->ast['orders'] = new OrderingNode();
		$columns = func_get_args();
		foreach($columns as $column){
			if($column instanceof Node){
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
		$this->core['having'] = new HavingNode($expression);
		
		return $this;
	}
	
	public function where($expression){
		$this->core['wheres'] = new WhereNode($expression);
		
		return $this;
	}
	
	public function join(Sql $relation, JoinNode $class = null){
		if(null === $relation){
			return $this;
		}
		if(null === $class){
			$class = new InnerJoinNode($relation);
		}
		$class = new $class($relation);
		$this->core['source']['right'] = $class;
		
		return $this;
	}
	
	public function on($expression){
		
	}


	
	public function from($table){
		if(!is_string($table)){
			$table = $table->getTable();
		}
		
		$this->core['source']['left'] = new LitteralNode($table);
	}
	
}

