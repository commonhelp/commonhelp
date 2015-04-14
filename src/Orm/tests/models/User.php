<?php
namespace Commonhelp\Orm;

class User extends ActiveRecord{
	
	public function __construct(){
		$layer = new PdoDataLayer($options);
		parent::__construct($layer);
	}
	
}