<?php
namespace Commonhelp\App;
use Commonhelp\DI\SimpleContainer;

interface ApplicationInterface{
	
	public static function main($controllerName, $methodName, SimpleContainer $container, array $urlParams = null);
	
	public static function part($controllerName, $methodName, SimpleContainer $container, array $urlParams = null);
	
}