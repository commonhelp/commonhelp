<?php

namespace Commonhelp\Orm\Sql;


interface SqlExpression{
	
	public function counter($distinct = false);
	
	public function sum();
	
	public function max();
	
	public function min();
	
	public function average();
	
}
