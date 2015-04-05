<?php

namespace Commonhelp\Orm\Sql;

class SqlSelectTest extends \PHPUnit_Framework_TestCase{
	
	public function testProject(){
		$users = Sql::table('users');
		$pStar = $users->project('*');
		$this->assertEquals('SELECT * FROM users', $pStar);
		$pComplex = $users->project($users['name'], $users['age']);
		$this->assertEquals('SELECT users.name, users.age FROM users', $pComplex);
	}
	
	public function testSqlWhere(){
		$users = Sql::table('users');
		$select = $users->project('*')->where($users['name']->eq('marcoski')->also($users['age']->lt('25')->otherwise($users['age']->gt('18'))));
		$this->assertEquals('SELECT * FROM users WHERE ((   users.name  =  marcoski   ) AND ((   users.age  <  25   ) OR (   users.age  >  18   )))', $select->toString());
	}
	
	public function testSqlOrder(){
		$users = Sql::table('users');
		$sOrder = $users->project('*')->where($users['name']->eq('marcoski'))->order($users['id']->desc(), $users['name']->asc());
		
		$this->assertEquals('SELECT * FROM users WHERE users.name  =  marcoski ORDER BY users.id DESC, users.name ASC', $sOrder);
	}
	
	public function testLimitOffset(){
		$users = Sql::table('users');
		$sLimit = $users->project('*')->take(10)->skip(20);
		
		$this->assertEquals('SELECT * FROM users LIMIT 10 OFFSET 20', $sLimit);
	}
	
	public function testGroupBy(){
		$users = Sql::table('users');
		$sGroup = $users->project('*')->group($users['name'], $users['age']);
		$this->assertEquals('SELECT * FROM users GROUP BY users.name, users.age', $sGroup);
	}
	
	public function testAlias(){
		$users = Sql::table('users');
		$as = $users->project($users['name']->alias('username'), $users['age']->alias('username_age'));
		
		$this->assertEquals("SELECT users.name AS username, users.age AS username_age FROM users", $as);
	}
	
	public function testHaving(){
		$users = Sql::table('users');
		$having = $users->project($users['name'])->having($users['age']->average()->lteq(25));
		
		$this->assertEquals("SELECT users.name FROM users HAVING AVERAGE(users.age)  <=  25", $having);
	}
	
	public function testJoin(){
		$users = Sql::table('users');
		$comments = Sql::table('comments');
		$join = $users->project('*')->join($comments);
		
		print $join.PHP_EOL;
		
	}
	
	
}
	

