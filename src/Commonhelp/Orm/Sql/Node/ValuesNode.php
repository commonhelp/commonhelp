<?php

namespace Commonhelp\Orm\Sql;

class ValuesNode extends Node{
	
	public function __construct(array $values, ColumnNode $columns){
		$this->value = array();
		foreach($columns as $key => $col){
			$this->value[$col->getValue()] = $values[$key];
		}
	}
	
	
	
}
