<?php

namespace Commonhelp\Orm\Sql;

class SqlDeleteTest extends \PHPUnit_Framework_TestCase{
	
	public function testDelete(){
		$users = Sql::table('users');
		$delete = new DeleteManager();
		$delete->from($users)->where($users['id']->eq(1))->take(1);
		
		$this->assertEquals("DELETE FROM users WHERE users.id  =  1 LIMIT 1", $delete->toString());
	}
	
}
	

