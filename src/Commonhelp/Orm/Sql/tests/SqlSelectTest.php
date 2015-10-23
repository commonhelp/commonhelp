<?php

namespace Commonhelp\Orm\Sql;

class SqlSelectTest extends \PHPUnit_Framework_TestCase{
	
	public function testProject(){
		$users = Sql::table('users');
		$pStar = $users->project('*');
		$this->assertEquals('SELECT * FROM "users"', $pStar->toSql());
		$pComplex = $users->project($users['name'], $users['age']);
		$this->assertEquals('SELECT "users"."name", "users"."age" FROM "users"', $pComplex->toSql());
	}
	
	public function testProjectDistinct(){
		$users = Sql::table('users');
		$pDistinct = $users->distinct()->project('*');
		$this->assertEquals("SELECT DISTINCT * FROM \"users\"", $pDistinct->toSql());
	}
	
	public function testSqlWhere(){
		$users = Sql::table('users');
		$select = $users->project('*')->where($users['name']->eq('marcoski')->also($users['age']->lt('25')->otherwise($users['age']->gt('18'))));
		$this->assertEquals('SELECT * FROM "users" WHERE ((   "users"."name"  =  \'marcoski\'   ) AND ((   "users"."age"  <  25   ) OR (   "users"."age"  >  18   )))', $select->toSql());
	}
	
	public function testNull(){
		$users = Sql::table('users');
		$select = $users->project('*')->where($users['name']->eq(null));
		
		$this->assertEquals("SELECT * FROM \"users\" WHERE \"users\".\"name\"  IS  NULL", $select->toSql());
	}
	
	public function testNotNull(){
		$users = Sql::table('users');
		$select = $users->project('*')->where($users['name']->not_eq(null));
		
		$this->assertEquals("SELECT * FROM \"users\" WHERE \"users\".\"name\"  IS NOT  NULL", $select->toSql());
	}
	
	public function testSqlOrder(){
		$users = Sql::table('users');
		$sOrder = $users->project('*')->where($users['name']->eq('marcoski'))->order($users['id']->desc(), $users['name']->asc());
		
		$this->assertEquals('SELECT * FROM "users" WHERE "users"."name"  =  \'marcoski\' ORDER BY "users"."id" DESC, "users"."name" ASC', $sOrder->toSql());
	}
	
	public function testLimitOffset(){
		$users = Sql::table('users');
		$sLimit = $users->project('*')->take(10)->skip(20);
		
		$this->assertEquals('SELECT * FROM "users" LIMIT 10 OFFSET 20', $sLimit->toSql());
	}
	
	public function testGroupBy(){
		$users = Sql::table('users');
		$sGroup = $users->project('*')->group($users['name'], $users['age']);
		$this->assertEquals('SELECT * FROM "users" GROUP BY "users"."name", "users"."age"', $sGroup->toSql());
	}
	
	public function testAlias(){
		$users = Sql::table('users');
		$as = $users->project($users['name']->alias('username'), $users['age']->alias('username_age'));
		
		$this->assertEquals("SELECT \"users\".\"name\" AS username, \"users\".\"age\" AS username_age FROM \"users\"", $as->toSql());
	}
	
	public function testHaving(){
		$users = Sql::table('users');
		$having = $users->project($users['name'])->having($users['age']->average()->lteq(25));
		
		$this->assertEquals("SELECT \"users\".\"name\" FROM \"users\" HAVING AVERAGE(\"users\".\"age\")  <=  25", $having->toSql());
	}
	
	public function testJoin(){
		$users = Sql::table('users');
		$comments = Sql::table('comments');
		$join = $users->project('*')->join($comments)->on($users['age']->eq('25'));
		$this->assertEquals("SELECT * FROM \"users\" INNER JOIN \"comments\" ON \"users\".\"age\"  =  25", $join->toSql());
	}
	
	public function testUnion(){
		$users = Sql::table('users');
		
		$first = $users->project($users['id'])->where($users['karma']->gt(100));
		$second = new SelectManager($users);
		$second->project($users['name'], $users['id'])->where($users['age']->gt(30));
		
		$union = $first->union($second);
		
		$this->assertEquals("(SELECT \"users\".\"id\" FROM \"users\" WHERE \"users\".\"karma\"  >  100 UNION SELECT \"users\".\"name\", \"users\".\"id\" FROM \"users\" WHERE \"users\".\"age\"  >  30)", $union->toSql());
		
	}
	
	
}
	

