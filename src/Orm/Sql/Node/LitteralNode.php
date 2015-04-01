<?php

namespace Commonhelp\Orm\Sql;


use Commonhelp\Util\Expression\Boolean\AndExpression;
use Commonhelp\Util\Expression\Boolean\OrExpression;
use Commonhelp\Util\Expression\Operator\NotEqualExpression;
use Commonhelp\Util\Expression\Expression;
use Commonhelp\Util\Expression\Operator\EqualExpression;
use Commonhelp\Util\Expression\Operator\GreaterThanEqualExpression;
use Commonhelp\Util\Expression\Operator\GreaterThanExpression;
use Commonhelp\Util\Expression\Operator\LessThanEqualExpression;
use Commonhelp\Util\Expression\Operator\LessThanExpression;
use Commonhelp\Orm\Exception\SqlException;


/**
 * 
 * @author marcoski
 * @ TODO QUOTED STRING using specific visitor for specific dbrms
 * @ TODO Implements BETWEEN and NOT BETWEEN Node
 */
class LitteralNode extends Node implements SqlExpression, SqlPredictions{
	
	public function __construct($value) {
		$this->value = $value;
	}
	
	
	//SQL EXPRESSIONS IMPLEMENTATION
	public function count($distinct = false){
		return new CountFunctionNode($this, $distinct);
	}
	
	public function sum(){
		return new SumFunctionNode($this, new LitteralNode('sum_id'));
	}
	
	public function max(){
		return new MaxFunctionNode($this, new LitteralNode('maximum'));
	}
	
	public function min(){
		return new MinFunctionNode($this, new LitteralNode('minimum'));
	}
	
	public function average(){
		return new AverageFunctionNode($this, new LitteralNode('average'));
	}
	
	//SQL PREDICTION IMPLEMENTATION
	public function not_eq($other){
		if(!($other instanceof LitteralNode)){
			$other = new LitteralNode($other);
		}
		return new GroupingNode(new NotEqualExpression($this, $other));
	}
	
	public function not_eq_any(array $others){
		return $this->grouping_any('not_eq', $others);
	}
	
	public function not_eq_all(array $others){
		return $this->grouping_all('not_eq', $others);
	}
	
	public function eq($other){
		if(!($other instanceof LitteralNode)){
			$other = new LitteralNode($other);
		}
		return new GroupingNode(new EqualExpression($this, $other));
	}
	
	public function eq_any(array $others){
		return $this->grouping_any('eq', $others);
	}
	
	public function eq_all(array $others){
		return $this->grouping_all('eq', $others);
	}
	
	public function in($other){
		if(!($other instanceof LitteralNode)){
			if(is_array($other)){
				$other = new LitteralNode(implode(',', $other));
			}else{
				throw new SqlException('Format not supported for IN expression');
			}
		}
		
		return new InNode($this, $other);
	}
	
	public function in_any(array $others){
		return $this->grouping_any('in', $others);
	}
	
	public function in_all(array $others){
		return $this->grouping_all('in', $others);
	}
	
	public function not_in($other){
		if(!($other instanceof LitteralNode)){
			if(is_array($other)){
				$other = new LitteralNode(implode(',', $other));
			}else{
				throw new SqlException('Format not supported for NOT IN expression');
			}
		}
		
		return new NotInNode($this, $other);
	}
	
	public function not_in_any(array $others){
		return $this->grouping_any('not_in', $others);
	}
	
	public function not_in_all(array $others){
		return $this->grouping_all('not_in', $others);
	}
	
	public function matches($other){
		if(!($other instanceof LitteralNode)){
			$other = new LitteralNode($other);
		}
		return new MatchingNode($this, $other);
	}
	
	public function match_any(array $others){
		return $this->grouping_any('matches', $others);
	}
	
	public function match_all(array $others){
		return $this->grouping_all('matches', $others);
	}
	
	public function does_not_match($other){
		if(!($other instanceof LitteralNode)){
			$other = new LitteralNode($other);
		}
		return new NotMatchingNode($this, $other);
	}
	
	public function does_not_match_any(array $others){
		return $this->grouping_any('does_not_match', $others);
	}
	
	public function does_not_match_all(array $others){
		return $this->grouping_all('does_not_match', $others);
	}
	
	public function gteq($other){
		if(!($other instanceof LitteralNode)){
			$other = new LitteralNode($other);
		}
		return new GroupingNode(new GreaterThanEqualExpression($this, $other));
	}
	
	public function gteq_any(array $others){
		return $this->grouping_any('gteq', $others);
	}
	
	public function gteq_all(array $others){
		return $this->grouping_all('gteq', $others);
	}
	
	public function gt($other){
		if(!($other instanceof LitteralNode)){
			$other = new LitteralNode($other);
		}
		return new GroupingNode(new GreaterThanExpression($this, $other));
	}
	
	public function gt_any(array $others){
		return $this->grouping_any('gt', $others);
	}
	
	public function gt_all(array $others){
		return $this->grouping_all('gt', $others);
	}
	
	public function lteq($other){
		if(!($other instanceof LitteralNode)){
			$other = new LitteralNode($other);
		}
		return new GroupingNode(new LessThanEqualExpression($this, $other));
	}
	
	public function lteq_any(array $others){
		return $this->grouping_any('lteq', $others);
	}
	
	public function lteq_all(array $others){
		return $this->grouping_all('lteq', $others);
	}
	
	public function lt($other){
		if(!($other instanceof LitteralNode)){
			$other = new LitteralNode($other);
		}
		return new GroupingNode(new LessThanExpression($this, $other));
	}
	
	public function lt_any(array $others){
		return $this->grouping_any('lt', $others);
	}
	
	public function lt_all(array $others){
		return $this->grouping_all('lt', $others);
	}
	
	public function grouping_any($method_id, array $others){
		$left = $this->$method_id(array_shift($others));
		
		foreach($others as $other)
		{
			$right = $this->$method_id($other);
			$left = new OrExpression($left, $right);
		}
		return new GroupingNode($left);
	}
	
	public function grouping_all($method_id, array $others){
		$left = $this->$method_id(array_shift($others));
		
		foreach($others as $other)
		{
			$right = $this->$method_id($other);
			$left = new AndExpression($left, $right);
		}
		return new GroupingNode($left);
	}
	
}