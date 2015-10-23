<?php

namespace Commonhelp\Orm;

class PgsqlDataAdaptee extends DataAdaptee{
	
	public function quoteTableName($string){
		return "\"{$string}\"";
	}
	
	public function quoteColumnName($string){
		return "\"{$string}\"";
	}

}
