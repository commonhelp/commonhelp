<?php

namespace Commonhelp\Orm\Sql;

abstract class AstManager{
	
	protected $visitor;
	protected $ast;
	
	public function __construct(){
		$this->visitor = new SqlVisitor();
	}
	
	public function toString(){
		return $this->visitor->visit($this->ast);
	}
	
	public function __toString(){
		return $this->toString();
	}
	
}

