<?php

namespace Commonhelp\Orm\Sql;

class MysqlVisitor extends SqlVisitor{
	
	/**
	 * @see http://dev.mysql.com/doc/refman/5.0/en/select.html#id3482214
	 */
	public function visitSelect(SelectNode $n){
		if(isset($n['offset']) && !isset($n['limit'])){
			$n['limit'] = new LimitNode(18446744073709551615);
		}
		return parent::visitSelect($n);
	}
	
	public function visitSelectCore(SelectCoreNode $n){
		if(null === $n->from()){
			$n->from(new LitteralNode('DUAL'));
		}
		return parent::visitSelectCore($n);
	}
	
	public function visitUpdate(UpdateNode $n){
		$wheres = isset($n['wheres']) ? $n['wheres'] : null;
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
	
		return $this->process($n).$table.$values.$where.$order.$limit;
	}
	
}
