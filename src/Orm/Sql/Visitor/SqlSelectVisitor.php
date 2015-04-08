<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;

class SqlSelectVisitor extends SqlVisitor{
	
	public function visitLimit(LimitNode $n){
		return $this->process($n);
	}
	
	public function visitOffset(OffsetNode $n){
		return $this->process($n);
	}
	
	public function visitDescending(DescendingNode $n){
		return $n['node']->accept($this).' DESC';
	}
	
	public function visitAscending(AscendingNode $n){
		return $n['node']->accept($this).' ASC';
	}
	
	public function visitProject(ProjectNode $ns){
		$collector = array();
		foreach($ns as $project){
			$collector[] = $project->accept($this);
		}
	
		return implode(', ', $collector);
	}
	
	public function visitGroup(GroupNode $ns){
		$collector = array();
		foreach($ns as $group){
			$collector[] = $group->accept($this);
		}
	
		return implode(', ', $collector);
	}
	
	public function visitOrdering(OrderingNode $ns){
		$collector = array();
		foreach($ns as $order){
			$collector[] = $order->accept($this);
		}
	
		return implode(', ', $collector);
	}
	
	public function visitAs(AsNode $n){
		return $n->getLeft()->accept($this)." AS ".$n->getRight()->accept($this);
	}
	
	public function visitHaving(HavingNode $n){
		$expression = $this->process($n);
		$opVisitor = new SqlOperatorVisitor();
		$expr = $expression->accept($opVisitor);
		return " HAVING {$expr}";
	}
	
	public function visitSelect(SelectNode $n){
		foreach($n['cores'] as $core){
			$selectCore = $core->accept($this);
		}
		
	
		$order = '';
		if(isset($n['orders'])){
			$order = ' ORDER BY ';
			$o = $n['orders']->accept($this);
			$order .= $o;
		}
	
		$limit = '';
		if(isset($n['limit'])){
			$limit = ' LIMIT ';
			$limit .= $n['limit']->accept($this);
		}
	
		$offset = '';
		if(isset($n['offset'])){
			$offset = ' OFFSET ';
			$offset .= $n['offset']->accept($this);
		}
	
		return $this->process($n).$selectCore.$order.$limit.$offset;
	}
	
	public function visitSelectCore(SelectCoreNode $n){
		$distinct = "";
		if(null !== $n['set_quantifier']){
			$distinct = $n['set_quantifier']->accept($this);
		}
		
		$projections = '';
		if(isset($n['projections'])){
			$projections .= ' ';
			$p = $n['projections']->accept($this);
			$projections .= $p;
		}
		
		$from='';
		if(isset($n['source'])){
			$f = $n['source']->accept($this);
			$from = ' FROM '.$f;
		}
		
		$group = '';
		if(isset($n['groups'])){
			$g = $n['groups']->accept($this);
			$group = ' GROUP BY '.$g;
			}
		
			$where = '';
			if(isset($n['wheres'])){
				$expr = $n['wheres']->accept($this);
			$where = " WHERE {$expr}";
		}
	
		$having = '';
		if(isset($n['having'])){
			$having = $n['having']->accept($this);
		}
		
		return $this->process($n).$distinct.$projections.$from.$where.$group.$having;
	}
	
	public function visitDistinct(DistinctNode $n){
		return " DISTINCT";
	}
	
	public function visitJoinSource(JoinSourceNode $n){
		$collector = '';
		if(null !== $n['left']){
			$collector .= $n['left']->accept($this);
		}
		if(null !== $n['right']){
			$collector .= $n['left'] !== null ? " " : ""; 
			$collector .= $n['right']->accept($this);
		}
		
		return $collector;
	}
	
	public function visitInnerJoin(InnerJoinNode $n){
		$collector = "INNER JOIN ";
		$collector .= $n['left']->accept($this);
		if(null !== $n['right']){
			$collector .= " ".$n['right']->accept($this);
		}
		
		return $collector;
	}
	
	public function visitOuterJoin(OuterJoinNode $n){
		$collector = "LEFT OUTER JOIN ";
		$collector .= $n['left']->accept($this). " ".$n['right']->accept($this);
		
		return $collector;
	}
	
	public function visitRightOuterJoin(RightOuterJoinNode $n){
		$collector = "RIGHT OUTRER JOIN ";
		$collector .= $n['left']->accept($this). " ".$n['right']->accept($this);
		
		return $collector;
	}
	
	public function visitFullOuterJoin(FullOuterJoinNode $n){
		$collector = "FULL OUTER JOIN ";
		$collector .= $n['left']->accept($this). " ".$n['right']->accept($this);
		
		return $collector;
	}
	
	public function visitUnion(UnionNode $n){
		if(null === $n->getOp()){
			return "(".$n['left']->accept($this)." UNION ".$n['right']->accept($this).")";
		}else if($n->getOp() == 'all'){
			return "(".$n['left']->accept($this)." UNION ALL ".$n['right']->accept($this).")";
		}
	}
	
	public function visitIntersect(IntersectNode $n){
		return "(".$n['left']->accept($this)." INTERSECT ".$n['right']->accept($this).")";
	}
	
	public function visitExcept(ExceptNode $n){
		return "(".$n['left']->accept($this)." EXCEPT ".$n['right']->accept($this).")";
	}
	
	public function visitCountFunction(CountFunctionNode $n){
		$distinct = $n->isDistinct() ? "DISTINCT " : "";
		list($name, $alias) = $this->processFunction($n);
	
		return "COUNT({$distinct}{$name}){$alias}";
	}
	
	public function visitMaxFunction(MaxFunctionNode $n){
		list($name, $alias) = $this->processFunction($n);
		
		return "MAXIMUM({$name}){$alias}";
	}
	
	public function visitMinFunction(MinFunctionNode $n){
		list($name, $alias) = $this->processFunction($n);
		
		return "MINIMUM({$name}){$alias}";
	}
	
	public function visitSumFunction(SumFunctionNode $n){
		list($name, $alias) = $this->processFunction($n);
		
		return "SUM({$name}){$alias}";
	}
	
	public function visitAverageFunction(AverageFunctionNode $n){
		list($name, $alias) = $this->processFunction($n);
		
		return "AVERAGE({$name}){$alias}";
	}
	
	protected function processFunction(FunctionNode $n){
		$alias = null !== $n['alias'] ? $n['alias']->accept($this) : null;
		$alias = null !== $alias ? " AS {$alias}" : "";
	
		$name = $this->process($n)->accept($this);
	
		return array($name, $alias);
	}
	
	
}
