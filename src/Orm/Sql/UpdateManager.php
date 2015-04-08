<?php

namespace Commonhelp\Orm\Sql;

class UpdateManager extends AstManager{
	
	public function __construct(){
		$this->ast = new UpdateNode();
	}
	
}



