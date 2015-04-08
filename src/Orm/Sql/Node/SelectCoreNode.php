<?php

namespace Commonhelp\Orm\Sql;

class SelectCoreNode extends Node{

	public function __construct(){
		$this['source'] = new JoinSourceNode(null, null);	
		$this['set_quantifier'] = null;
	}
}
