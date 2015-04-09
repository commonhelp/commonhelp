<?php
namespace Commonhelp\Ldap;

use Commonhelp\Util\Expression\Context\FilterContext;
use Commonhelp\Ldap\Filters\FilterExpression;
use Commonhelp\Util\Expression\Boolean\OrExpression;
use Commonhelp\Util\Expression\Boolean\AndExpression;
use Commonhelp\Util\Expression\Boolean\NotExpression;
class LdapSessionTest extends \PHPUnit_Framework_TestCase{
	
	protected $options = array(
		'host' 		=> 'ponteserver.unponteper.it',
		'username' => 'cn=admin,dc=unponteper,dc=it',
		'password' => 'Missioni2010',
		'basedn' => 'dc=unponteper,dc=it'
	);
	
	protected $baseDn = 'dc=unponteper,dc=it';
	
	protected $validDn = 'cn=admin,dc=unponteper,dc=it';
	protected $invalidDn = 'cn=admin,dc=unponteper,dc';
	
	public function testConnection(){
		$session = new LdapSession($this->options);
		$res = $session->getResource();
		
		//print_r($res);
	}
	
	public function testValidDn(){
		Dn::factory($this->validDn);
	}
	
	public function testRead(){
		// (&(|(objectClass=sambaAccount)(objectClass=sambaSamAccount))(objectClass=posixAccount)(!(uid=*$)))
		// (&(|(A)(B))(C)(!(B))) -> (A | B) & (C) & (B) -> (A | B9) & ((C) & (!B))
		 
		$session = new LdapSession($this->options);
		$reader = $session->getReader();
		$filter = new Filter();
		$expression = new AndExpression(
			new OrExpression(
				new FilterExpression('objectClass=sambaAccount'),
				new FilterExpression('objectClass=sambaSamAccount')
			),
			new AndExpression(
				new FilterExpression('objectClass=posixAccount'),
				new NotExpression(
					new FilterExpression('uid=*$')
				)
			)
		);
		
		$filterStr = $filter->visit($expression);
		$rs = $reader->search($session->getBaseDn(), '(&(|(objectClass=sambaAccount)(objectClass=sambaSamAccount))(objectClass=posixAccount)(!(uid=*$)))');
		foreach($rs as $result){
			print_r($result);
			break;
		}
	}
	
	public function testFilterBase(){
		$expected = "(|(objectClass=inetOrgPerson)(objectClass=user))";
		$filter = new Filter();
		
		$expression = new OrExpression(
			new FilterExpression('objectClass=inetOrgPerson'), 
			new FilterExpression('objectClass=user')
		);
		
		$parsed = $filter->visit($expression);
		$this->assertEquals($expected, $parsed);
	}
	
	public function testFilter(){
		$expected = "(&(|(objectClass=inetOrgPerson)(objectClass=user))(userCertificate=*))";
		$filter = new Filter();
		
		$expression = new AndExpression(
				new OrExpression(
					new FilterExpression('objectClass=inetOrgPerson'),
					new FilterExpression('objectClass=user')
				), 
				new FilterExpression('userCertificate=*')
		);
		
		$parsed = $filter->visit($expression);
		$this->assertEquals($expected, $parsed);
	}
	
	public function testFilterNot(){
		$expected = "(&(objectClass=inetOrgPerson)(!(mail=*)))";
		$filter = new Filter();
		
		$expression = new AndExpression(
			new FilterExpression('objectClass=inetOrgPerson'),
			new NotExpression(
				new FilterExpression('mail=*')
			)
		);
		
		$parsed = $filter->visit($expression);
		$this->assertEquals($expected, $parsed);
	}
	
}

?>