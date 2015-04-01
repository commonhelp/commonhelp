<?php

namespace Commonhelp\Orm\Sql;

class SqlTest extends \PHPUnit_Framework_TestCase{
	
	
	
	public function testSql(){
		$users = Sql::table('users');
		
		$select = $users->project('*')->where($users['name']->eq('marcoski')->also($users['age']->lt('25')));
		
		print_r($select->getAst());
	}
}
	

