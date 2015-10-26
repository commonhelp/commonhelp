<?php

namespace Commonhelp\Orm\DataLayer\DataAdaptee;

class DbiniDataAdaptee extends DataAdaptee{
	
	public function quoteTableName($string){
		return "[{$string}]";
	}
	
	public function quoteColumnName($string){
		return "[{$string}]";
	}
	
}
