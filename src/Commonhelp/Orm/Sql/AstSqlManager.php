<?php

namespace Commonhelp\Orm\Sql;

use Commonhelp\Util\Expression\AstManager;
use Commonhelp\Orm\Sql\Visitor\SqlVisitor;

abstract class AstSqlManager implements AstManager{
	
	const UNION = 0;
	const INTERSECT = 1;
	
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
	
	protected function mergeExpression(array $expression, $op){
		if(count($expression) == 1){
			return $expression[0];
		}
		
		$left = array_shift($expression);
		$right = array_shift($expression);
		if($op == self::INTERSECT){
			array_unshift($expression, $left->also($right));
		}else if($op == self::UNION){
			array_unshift($expression, $left->otherwise($right));
		}
		return $this->mergeExpression($expression, $op);
	}
	
}

