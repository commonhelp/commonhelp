<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;

class SqlVisitor extends Visitor{
	
	protected $connection;
	
	public function __construct($connection = null){
		parent::__construct(true);
		$this->connection = $connection;
	}
	
	public function visit(Expression $e){
		$visiting = 'visit'.str_replace('Node', '', $e);
		
		return $this->$visiting($e);
	}
	
	public function visitLitteral(LitteralNode $n){
		return $this->process($n);
	}
	
	public function visitAttribute(AttributeNode $n){
		return $n->getRelation().'.'.$n->getValue();
	}
	
	public function visitLimit(LimitNode $n){
		return " LIMIT ".$this->process($n);
	}
	
	public function visitWhere(WhereNode $n){
		$expression = $this->process($n);
		if(!($expression instanceof BinaryExpression)){
			throw new SqlException('Expression must be of BinaryExpression Type');
		}
		if($expression instanceof OperatorExpression){
			$visitor = new SqlOperatorVisitor();
		}
		if($expression instanceof BooleanExpression){
			$visitor = new SqlBooleanVisitor();
		}
		
		return " WHERE ".$expression->accept($visitor);
	}
	
	public function visitOn(OnNode $n){
		$collector = "ON ";
		$expression = $n['node'];
		if($expression instanceof OperatorExpression){
			$visitor = new SqlOperatorVisitor();
		}
		
		return $collector.$n['node']->accept($visitor);
	}
	
	public function visitUpdate(UpdateNode $n){
		if(!isset($n['orders']) && !isset($n['limit'])){
			$wheres = $n['wheres'];
		}else{
			$wheres = new InNode($n['key'], $this->buildSubSelect($n['key'], $n));
		}
		$table = '';
		if(isset($n['relation'])){
			$table .= $n['relation']->getRelation();
		}
	
		$values = '';
		if(isset($n['values'])){
			$vals = array();
			foreach($n['values'] as $value){
				$opVisit = new SqlOperatorVisitor();
				$vals[] = $value->accept($opVisit);
			}
			$values = " SET ".implode(', ', $vals);
		}
	
		$where = '';
		if(isset($n['wheres'])){
			$expr = $n['wheres']->accept($this);
			$where = $expr;
		}
	
		return $this->process($n).$table.$values.$where;
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
			$where = $expr;
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
	
	public function visitInsert(InsertNode $n){
		$table = '';
		if(isset($n['relation'])){
			$table = $n['relation']->getRelation();
		}
	
		$columns = '';
		if(isset($n['columns'])){
			$columns = $n['columns']->accept($this);
		}
	
		$values = '';
		if(isset($n['values'])){
			$values = $n['values']->accept($this);
		}else if(isset($n['select'])){
			$values = $n['select']->toString();
		}
	
		return $this->process($n).$table.$columns.$values;
	}
	
	public function visitColumn(ColumnNode $ns){
		if(count($ns) == 0){
			return '';
		}
		$collector = array();
		foreach($ns as $n){
			$collector[] = $n->getValue();
		}
	
		return " (".implode(', ', $collector).") ";
	}
	
	public function visitValues(ValuesNode $n){
		return "VALUES (".implode(', ', $n->getValue()).")";
	}
	
	protected function processFunction(FunctionNode $n){
		$alias = null !== $n['alias'] ? $n['alias']->accept($this) : null;
		$alias = null !== $alias ? " AS {$alias}" : "";
	
		$name = $this->process($n)->accept($this);
	
		return array($name, $alias);
	}
	
	public function visitDelete(DeleteNode $n){
		$relation = " FROM ".$n['relation']->accept($this);
	
		$where="";
		if(isset($n['wheres'])){
			$expr = $n['wheres']->accept($this);
			$where = $expr;
		}
	
		$limit="";
		if(isset($n['limit'])){
			$limit = $n['limit']->accept($this);
		}
	
		return $this->process($n).$relation.$where.$limit;
	}
	
	protected function buildSubSelect($key, UpdateNode $n){
		$stmt = new SelectNode();
		$core = $stmt['core']->current();
		$core['source']['left'] = new LitteralNode($n['relation']->getTable());
		$core['projections'] = new ProjectNode();
		$core['projections'][] = $key;
		$core['wheres'] = $n['wheres'];
		$stmt['limit'] = $n['limit'];
		$stmt['orders'] = $n['orders'];
	
		return $stmt;
	}
	

	public function process(Expression $e){
		return $e->getValue();
	}
	
	protected function quote($name){
		if(null === $this->connection){
			return "'{$name}'";
		}
		
		return $this->connection->quote($name);
	}
	
	protected function quoteColumnName($name){
		if(null === $this->connection){
			return "\"{$name}\"";
		}
		
		return $this->connection->quoteColumnName($name);
	}
	
	protected function quoteTableName($name){
		if(null === $this->connection){
			return "\"{$name}\"";
		}
		
		return $this->connection->quoteTableName($name);
	}
	
	
	
}
