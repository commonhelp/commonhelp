<?php
namespace Commonhelp\App;

use Commonhelp\Config\Config;
/**
*/
class SystemConfig extends Config{
	
	protected $validMethodList = array(
		'getSecret',
		'setSecret',
		'getHashingCost',
		'setHashingCost',
		'getPasswordsalt',
		'setPasswordsalt',
		'getTrustedDomains',
		'setTrustedDomains',
		'getOverwritehost',
		'setOverwritehost',
		'getDbDsn',
		'setDbDsn',
		'getDbUsername',
		'setDbUsername',
		'getDbPassword',
		'setDbPassword',
		'setDbType',
		'getDbType'
	);
	
	
	
}