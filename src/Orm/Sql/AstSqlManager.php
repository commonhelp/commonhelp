<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Orm\PdoDataLayer;
use Commonhelp\Util\Expression\AstManager;

abstract class AstSqlManager implements AstManager{
	
	protected $visitor;
	protected $ast;
	protected $engine;
	
	public function __construct(){
		$this->visitor = new SqlVisitor();
		$this->engine = null;
	}
	
	public function engine($engine){
		$this->engine = $engine;
		$this->visitor = $engine->getVisitor();
	}
	
	public function toSql(){
		return $this->ast->accept($this->visitor);
	}
	
	public function getAst(){
		return $this->ast;
	}
	
	public function getVisitor(){
		return $this->visitor;
	}
	
	public function __toString(){
		return $this->toSql();
	}
	
}

