<?php

namespace Commonhelp\Orm;

class SqliteDataAdaptee extends DataAdaptee{
	
	public function quoteTableName($string){
		return "\"{$string}\"";
	}
	
	public function quoteColumnName($string){
		return "\"{$string}\"";
	}
	
}
