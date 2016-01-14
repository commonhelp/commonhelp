<?php
namespace Commonhelp\App;

use Commonhelp\DI\SimpleContainer;
use Commonhelp\App\Exception\ApplicationException;
abstract class AbstractApplication{

	protected $container;
	
	public function __construct(){
		$this->container = null;
	}
	
	public function dispatch($controllerName, $methodName){
		if(is_null($this->container)){
			throw new ApplicationException('None container initialized');
		}
		
		self::main($controllerName, $methodName, $this->container);
	}
	
	public function getContainer(){
		return $this->container;
	}
	
	abstract public static function main($controllerName, $methodName, SimpleContainer $container, array $urlParams = null);
	
	abstract public static function part($controllerName, $methodName, SimpleContainer $container, array $urlParams = null);

}