<?php

namespace Commonhelp\Orm\Sql;

class SqlTest extends \PHPUnit_Framework_TestCase{
	
	
	
	public function testSql(){
		$users = Sql::table('users');
		
		print_r($users->project('*'));
	}
}
	

