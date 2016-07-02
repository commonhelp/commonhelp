<?php

namespace Commonhelp\Orm\DataLayer\DataAdaptee;

abstract class DataAdaptee{

	protected $visitor;
	
	
	public function getVisitor(){
		return $this->visitor;
	}
	
	abstract function quoteTableName($string);
	abstract function quoteColumnName($string);
	
}
