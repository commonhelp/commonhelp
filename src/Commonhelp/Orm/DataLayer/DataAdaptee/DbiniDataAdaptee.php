<?php

namespace Commonhelp\Orm;

class DbiniDataAdaptee extends DataAdaptee{
	
	public function quoteTableName($string){
		return "[{$string}]";
	}
	
	public function quoteColumnName($string){
		return "[{$string}]";
	}
	
}
