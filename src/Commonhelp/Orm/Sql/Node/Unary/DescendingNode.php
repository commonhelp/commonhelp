<?php

namespace Commonhelp\Orm\Sql;



class DescendingNode extends UnaryNode{
	
	public function reverse(){
		return new AscendingNode($this['node']);
	}
	
}
