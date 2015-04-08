<?php

namespace Commonhelp\Orm\Sql;

class DeleteManager extends AstManager{

	public function __construct(){
		$this->ast = new DeleteNode();
	}
}


