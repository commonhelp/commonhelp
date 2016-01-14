<?php
namespace Commonhelp\App;

use Commonhelp\Config\Config;
use Commonhelp\Orm\DataLayer\PdoDataLayer;
/**
*/
class ApplicationConfig extends Config{
	
	protected $validMethodList = array(
		'getDbLayer',
		'setDbLayer',
		'getSystemConfig',
		'setSystemConfig'
	);
	
	public function __construct(PdoDataLayer $dbLayer, SystemConfig $systemConfig){
		$this->setDbLayer($dbLayer);
		$this->setSystemConfig($systemConfig);
	}
	
}