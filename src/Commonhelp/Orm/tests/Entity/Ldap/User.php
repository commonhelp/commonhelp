<?php
namespace Test\Ldap;

use Commonhelp\Orm\Entity;
class User extends Entity{
	
	protected $cn;
	protected $dn;
	protected $sn;
	protected $uid;
	protected $geco;
	protected $gidNumber;
	protected $homeDirectory;
	protected $loginShell;
	protected $objectClas;
	protected $sambaAcctFlag;
	protected $sambaHomeDrive;
	protected $sambaHomePath;
	protected $sambaKickoffTime;
	protected $sambaLMPassword;
	protected $sambaLogoffTime;
	protected $sambaLogonTime;
	protected $sambaNTPassword;
	protected $sambaPrimaryGroupSID;
	protected $sambaProfilePath;
	protected $sambaPwdCanChange;
	protected $sambaPwdLastSet;
	protected $sambaPwdMustChange;
	protected $sambaSID;
	protected $shadowLastChange;
	protected $shadowMax;
	protected $uidNumber;
	protected $userPassword;
	protected $displayName;
	protected $givenName;
	protected $mail;
	
	public function __construct(){
		$this->fieldMap['uidNumber'] = 'id';
	}
	
}