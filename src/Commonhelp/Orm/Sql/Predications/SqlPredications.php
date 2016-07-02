<?php

namespace Commonhelp\Orm\Sql\Predications;


interface SqlPredications{
	
	function not_eq($other);
	
	function not_eq_any(array $others);
	
	function not_eq_all(array $others);
	
	function eq($other);
	
	function eq_any(array $others);
	
	function eq_all(array $others);
	
	function in($other);
	
	function in_any(array $others);
	
	function in_all(array $others);
	
	function not_in($other);
	
	function not_in_any(array $others);
	
	function not_in_all(array $others);
	
	function matches($other);
	
	function match_any(array $others);
	
	function match_all(array $others);
	
	function does_not_match($other);
	
	function does_not_match_any(array $others);
	
	function does_not_match_all(array $others);
	
	function gteq($other);
	
	function gteq_any(array $others);
	
	function gteq_all(array $others);
	
	function gt($other);
	
	function gt_any(array $others);
	
	function gt_all(array $others);
	
	function lteq($other);
	
	function lteq_any(array $others);
	
	function lteq_all(array $others);
	
	function lt($other);
	
	function lt_any(array $others);
	
	function lt_all(array $others);
	
	function grouping_any($method_id, array $others);
	
	function grouping_all($method_id, array $others);
	
}
