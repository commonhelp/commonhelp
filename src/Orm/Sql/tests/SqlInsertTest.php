<?php

namespace Commonhelp\Orm\Sql;

class SqlInsertTest extends \PHPUnit_Framework_TestCase{
	
	public function testInsert(){
		$users = Sql::table('users');
		$insert = new InsertManager();
		$insert->insert(array(array($users['name'], 'Bob'), array($users['admin'], true)));
		
		$this->assertEquals("INSERT INTO users (name, admin) VALUES (Bob, 1)", $insert);
	}
	
	public function testInsertSelect(){
		$users = Sql::table('users');
		$insert = new InsertManager();
		$insert->into($users);
		$insert->columns($users['name']);
		$insert->columns($users['admin']);
		$select = $users->project($users['name'], $users['admin'])->where($users['age']->gt(20));
		
		$insert->select($select);
		
		$this->assertEquals("INSERT INTO users (name, admin) SELECT users.name, users.admin FROM users WHERE users.age  >  20", $insert);
	}
	
}
	

