<?php

namespace Commonhelp\Orm\Sql;

abstract class AstManager{
	
	protected $visitor;
	protected $ast;
	
	public function __construct(){
		$this->visitor = new SqlVisitor();
	}
	
	public function toString(){
		return $this->ast->accept($this->visitor);
	}
	
	public function getAst(){
		return $this->ast;
	}
	
	public function getVisitor(){
		return $this->visitor;
	}
	
	public function __toString(){
		return $this->toString();
	}
	
}

