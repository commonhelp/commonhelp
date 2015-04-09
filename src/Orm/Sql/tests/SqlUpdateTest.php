<?php

namespace Commonhelp\Orm\Sql;

class SqlUpdateTest extends \PHPUnit_Framework_TestCase{
	
	public function testUpdate(){
		$users = Sql::table('users');
		$update = new UpdateManager();
		$update->table($users);
		$update->set(array(array($users['name'], 'Bob'), array($users['admin'], true)));
		$update->where($users['id']->eq(1));
		
		$this->assertEquals("UPDATE users SET users.name  =  Bob, users.admin  =  1 WHERE users.id  =  1", $update);
	}
	
}
	

