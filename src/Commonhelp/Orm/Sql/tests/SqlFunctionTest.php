<?php

namespace Commonhelp\Orm\Sql;

class SqlFunctionTest extends \PHPUnit_Framework_TestCase{
	
	public function testCounter(){
		$users = Sql::table('users');
		$pCountAs = $users->project($users['vip']->counter()->alias('count_vip'));
		
		$this->assertEquals("SELECT COUNT(\"users\".\"vip\") AS \"count_vip\" FROM \"users\"", $pCountAs->toSql());
		
	}
	
	public function testMax(){
		$users = Sql::table('users');
		$max = $users->project($users['vip']->max()->alias('maximum'));
		
		$this->assertEquals("SELECT MAXIMUM(\"users\".\"vip\") AS \"maximum\" FROM \"users\"", $max->toSql());
	}
	
	public function testMin(){
		$users = Sql::table('users');
		$min = $users->project($users['vip']->min()->alias('minimum'));
		
		$this->assertEquals("SELECT MINIMUM(\"users\".\"vip\") AS \"minimum\" FROM \"users\"", $min->toSql());
	}
	
	public function testSum(){
		$users = Sql::table('users');
		$sum = $users->project($users['vip']->sum()->alias('sum'));
		
		$this->assertEquals("SELECT SUM(\"users\".\"vip\") AS \"sum\" FROM \"users\"", $sum->toSql());
	}
	
	public function testAverage(){
		$users = Sql::table('users');
		$avg = $users->project($users['vip']->average()->alias('average'));
		
		$this->assertEquals("SELECT AVERAGE(\"users\".\"vip\") AS \"average\" FROM \"users\"", $avg->toSql());
	}
	
	
}
