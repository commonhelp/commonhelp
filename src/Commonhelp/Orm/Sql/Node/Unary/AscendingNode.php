<?php

namespace Commonhelp\Orm\Sql;



class AscendingNode extends UnaryNode{
	
	
	public function reverse(){
		return new DescendingNode($this['node']);
	}
	
}
