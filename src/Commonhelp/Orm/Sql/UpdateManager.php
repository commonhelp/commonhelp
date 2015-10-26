<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Operator\EqualExpression;
use Commonhelp\Orm\Sql\Node\AttributeNode;
use Commonhelp\Orm\Sql\Node\Unary\LimitNode;
use Commonhelp\Orm\Sql\Node\OrderingNode;
use Commonhelp\Orm\Sql\Node\LitteralNode;
use Commonhelp\Orm\Sql\Node\WhereNode;
use Commonhelp\Orm\Sql\Node\UpdateNode;
use Commonhelp\Orm\Sql\Node\Node;

class UpdateManager extends AstSqlManager{
	
	public function __construct(){
		parent::__construct();
		$this->ast = new UpdateNode();
	}
	
	public function table(Sql $table){
		$this->ast['relation'] = new AttributeNode(null, $table);
		return $this;
	}
	
	public function set($values){
		$vals = array();
		foreach($values as $v){
			list($column, $value) = $v;
			$vals[] = new EqualExpression(
				$column, 
				new LitteralNode($value, true)
			);
		}
	
		$this->ast['values'] = $vals;
	}
	
	public function take($amount){
		$this->ast['limit'] = new LimitNode($amount);
	
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
	
	public function where($expression, $op=self::INTERSECT){
		if(is_array($expression)){
			$expression = $this->mergeExpression($expression, $op);
		}
		$this->ast['wheres'] = new WhereNode($expression);
	
		return $this;
	}
	
	public function key(AttributeNode $key){
		$this->ast['key'] = $key;
	}
	
}



