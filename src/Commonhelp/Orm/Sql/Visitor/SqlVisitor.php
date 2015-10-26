<?php

namespace Commonhelp\Orm\Sql\Visitor;

use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Orm\Exception\SqlException;
use Commonhelp\Util\Expression\BinaryExpression;
use Commonhelp\Util\Expression\Operator\OperatorExpression;
use Commonhelp\Util\Expression\Boolean\BooleanExpression;
use Commonhelp\Orm\Sql\Node\LitteralNode;
use Commonhelp\Orm\Sql\Node\AttributeNode;
use Commonhelp\Orm\Sql\Node\Unary\LimitNode;
use Commonhelp\Orm\Sql\Node\WhereNode;
use Commonhelp\Orm\Sql\Node\BinaryNode;
use Commonhelp\Orm\Sql\Node\Binary\MatchingNode;
use Commonhelp\Orm\Sql\Node\Binary\NotMatchingNode;
use Commonhelp\Orm\Sql\Node\Unary\OnNode;
use Commonhelp\Orm\Sql\Node\UpdateNode;
use Commonhelp\Orm\Sql\Node\Binary\InNode;
use Commonhelp\Orm\Sql\Node\Unary\OffsetNode;
use Commonhelp\Orm\Sql\Node\Unary\AscendingNode;
use Commonhelp\Orm\Sql\Node\Unary\DescendingNode;
use Commonhelp\Orm\Sql\Node\ProjectNode;
use Commonhelp\Orm\Sql\Node\Binary\AsNode;
use Commonhelp\Orm\Sql\Node\GroupNode;
use Commonhelp\Orm\Sql\Node\OrderingNode;
use Commonhelp\Orm\Sql\Node\Unary\HavingNode;
use Commonhelp\Orm\Sql\Node\SelectNode;
use Commonhelp\Orm\Sql\Node\SelectCoreNode;
use Commonhelp\Orm\Sql\Node\DistinctNode;
use Commonhelp\Orm\Sql\Node\Join\JoinSourceNode;
use Commonhelp\Orm\Sql\Node\Join\InnerJoinNode;
use Commonhelp\Orm\Sql\Node\Join\OuterJoinNode;
use Commonhelp\Orm\Sql\Node\Join\FullOuterJoinNode;
use Commonhelp\Orm\Sql\Node\Join\RightOuterJoinNode;
use Commonhelp\Orm\Sql\Node\Binary\UnionNode;
use Commonhelp\Orm\Sql\Node\Binary\IntersectNode;
use Commonhelp\Orm\Sql\Node\Binary\ExceptNode;
use Commonhelp\Orm\Sql\Node\Functions\CountFunctionNode;
use Commonhelp\Orm\Sql\Node\Functions\MaxFunctionNode;
use Commonhelp\Orm\Sql\Node\Functions\MinFunctionNode;
use Commonhelp\Orm\Sql\Node\Functions\SumFunctionNode;
use Commonhelp\Orm\Sql\Node\Functions\AverageFunctionNode;
use Commonhelp\Orm\Sql\Node\FunctionNode;
use Commonhelp\Orm\Sql\Node\InsertNode;
use Commonhelp\Orm\Sql\Node\ValuesNode;
use Commonhelp\Orm\Sql\Node\DeleteNode;
use Commonhelp\Orm\Sql\Node\ColumnNode;



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
		if($n->isToQuote()){
			return $this->quote($this->process($n));
		}
		return $this->process($n);
	}
	
	public function visitAttribute(AttributeNode $n){
		return $this->quoteTableName($n->getRelation()).'.'.$this->quoteColumnName($n->getValue());
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
			$visitor = new SqlOperatorVisitor($this);
			$expr = $expression->accept($visitor);
		}
		if($expression instanceof BooleanExpression){
			$visitor = new SqlBooleanVisitor($this);
			$expr = $expression->accept($visitor);
		}
		if($expression instanceof BinaryNode){
			$expr = $expression->accept($this);
		}
		
		return " WHERE ".$expr;
	}
	
	public function visitMatching(MatchingNode $n){
		$collector = $this->quoteColumnName($n['left']->accept($this));
		$collecotr .= " LIKE ";
		$collector .= $this->quote($n['right']->accept($this));
		if(null !== $n->getEscape()){
			$collector .= " ESCAPE ";
			$collector .= $n->getEscape()->accept($this);
		}
		
		return $collector;
	}
	
	public function visitNotMatching(NotMatchingNode $n){
		$collector = $this->quoteColumnName($n['left']->accept($this));
		$collecotr .= " NOT LIKE ";
		$collector .= $this->quote($n['right']->accept($this));
		if(null !== $n->getEscape()){
			$collector .= " ESCAPE ";
			$collector .= $n->getEscape()->accept($this);
		}
		
		return $collector;
	}
	
	public function visitOn(OnNode $n){
		$collector = "ON ";
		$expression = $n['node'];
		if($expression instanceof OperatorExpression){
			$visitor = new SqlOperatorVisitor($this);
		}
		
		return $collector.$n['node']->accept($visitor);
	}
	
	public function visitUpdate(UpdateNode $n){
		if(!isset($n['orders']) && !isset($n['limit'])){
			$wheres = isset($n['wheres']) ? $n['wheres'] : null;
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
				$opVisit = new SqlOperatorVisitor($this);
				$vals[] = $value->accept($opVisit);
			}
			$values = " SET ".implode(', ', $vals);
		}
	
		$where = '';
		if(null !== $wheres){
			$expr = $wheres->accept($this);
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
		$opVisitor = new SqlOperatorVisitor($this);
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
			$collector .= $this->quoteTableName($n['left']->accept($this));
		}
		if(null !== $n['right']){
			$collector .= $n['left'] !== null ? " " : "";
			$collector .= $n['right']->accept($this);
		}
	
		return $collector;
	}
	
	public function visitInnerJoin(InnerJoinNode $n){
		$collector = "INNER JOIN ";
		$collector .= $this->quoteTableName($n['left']->accept($this));
		if(null !== $n['right']){
			$collector .= " ".$n['right']->accept($this);
		}
	
		return $collector;
	}
	
	public function visitOuterJoin(OuterJoinNode $n){
		$collector = "LEFT OUTER JOIN ";
		$collector .= $this->quoteTableName($n['left']->accept($this)). " ".$n['right']->accept($this);
	
		return $collector;
	}
	
	public function visitRightOuterJoin(RightOuterJoinNode $n){
		$collector = "RIGHT OUTRER JOIN ";
		$collector .= $this->quoteTableName($n['left']->accept($this)). " ".$n['right']->accept($this);
	
		return $collector;
	}
	
	public function visitFullOuterJoin(FullOuterJoinNode $n){
		$collector = "FULL OUTER JOIN ";
		$collector .= $this->quoteTableName($n['left']->accept($this)). " ".$n['right']->accept($this);
	
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
			$table = $this->quoteTableName($n['relation']->getRelation());
		}
	
		$columns = '';
		if(isset($n['columns'])){
			$columns = $n['columns']->accept($this);
		}
	
		$values = '';
		if(isset($n['values'])){
			$values = $n['values']->accept($this);
		}else if(isset($n['select'])){
			$values = $n['select']->toSql();
		}
	
		return $this->process($n).$table.$columns.$values;
	}
	
	public function visitColumn(ColumnNode $ns){
		if(count($ns) == 0){
			return '';
		}
		$collector = array();
		foreach($ns as $n){
			$collector[] = $this->quoteColumnName($n->getValue());
		}
	
		return " (".implode(', ', $collector).") ";
	}
	
	public function visitValues(ValuesNode $n){
		$vals = array();
		foreach($n->getValue() as $val){
			$vals[] = $this->quote($val);
		}
		return "VALUES (".implode(', ', $vals).")";
	}
	
	protected function processFunction(FunctionNode $n){
		$alias = null !== $n['alias'] ? $n['alias']->accept($this) : null;
		if(null !== $alias){
			$alias = $this->quoteColumnName($alias);
		}
		$alias = null !== $alias ? " AS {$alias}" : "";
	
		$name = $this->process($n)->accept($this);
	
		return array($name, $alias);
	}
	
	public function visitDelete(DeleteNode $n){
		$relation = " FROM ".$this->quoteTableName($n['relation']->accept($this));
	
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
	
	public function quote($name){
		if(null === $this->connection){
			return "'{$name}'";
		}
		
		return $this->connection->quote($name);
	}
	
	public function quoteColumnName($name){
		if(null === $this->connection){
			return "\"{$name}\"";
		}
		
		return $this->connection->quoteColumnName($name);
	}
	
	public function quoteTableName($name){
		if(null === $this->connection){
			return "\"{$name}\"";
		}
		return $this->connection->quoteTableName($name);
	}
	
	
	
}
