<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\Sql\Node\SelectNode;
use Commonhelp\Orm\Sql\Node\LitteralNode;
use Commonhelp\Orm\Sql\Node\ProjectNode;
use Commonhelp\Orm\Sql\Node\GroupNode;
use Commonhelp\Orm\Sql\Node\OrderingNode;
use Commonhelp\Orm\Sql\Node\Unary\OffsetNode;
use Commonhelp\Orm\Sql\Node\Unary\LimitNode;
use Commonhelp\Orm\Sql\Node\Unary\HavingNode;
use Commonhelp\Orm\Sql\Node\WhereNode;
use Commonhelp\Orm\Sql\Node\Join\InnerJoinNode;
use Commonhelp\Orm\Sql\Node\Unary\OnNode;
use Commonhelp\Orm\Sql\Node\DistinctNode;
use Commonhelp\Orm\Sql\Node\Binary\IntersectNode;
use Commonhelp\Orm\Sql\Node\Binary\UnionNode;
use Commonhelp\Orm\Sql\Node\Binary\ExceptNode;
use Commonhelp\Orm\Sql\Node\Node;


class SelectManager extends AstSqlManager{
	
	protected $core;
	
	public function __construct($table = null){
		parent::__construct();
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
	
	public function where($expression, $op=self::INTERSECT){
		if(is_array($expression)){
			$expression = $this->mergeExpression($expression, $op);
		}
		$this->core['wheres'] = new WhereNode($expression);
		
		return $this;
	}
	
	public function join(Sql $relation, JoinNode $class = null){
		if(null === $relation){
			return $this;
		}
		if(null === $class){
			$class = new InnerJoinNode($relation, null);
		}
		$class = new $class($relation, null);
		$this->core['source']['right'] = $class;
		
		return $this;
	}
	
	public function on($expression){
		$oR = $this->core['source']['right']['right'] = new OnNode($expression);
		return $this;
	}

	public function distinct($value = true){
		if($value){
			$this->core['set_quantifier'] = new DistinctNode();
		}else{
			$this->core['set_quantifier'] = null;
		}
		
		return $this;
	}
	
	public function with(){
		
	}
	
	public function union(SelectManager $other, $operation=null){
		$this->ast = new UnionNode($this->ast, $other->getAst(), $operation);
		return $this;
	}
	
	public function intersect(SelectManager $other){
		$this->ast = new IntersectNode($this->ast, $other->getAst());
		return $this;
	}
	
	public function except(){
		$this->ast = new ExceptNode($this->ast, $other->getAst());
		return $this;
	}
	
	public function from($table){
		if(!is_string($table)){
			$table = $table->getTable();
		}
		
		$this->core['source']['left'] = new LitteralNode($table);
	}
	
}

