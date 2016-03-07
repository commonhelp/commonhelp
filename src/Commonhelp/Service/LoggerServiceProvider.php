<?php
namespace Commonhelp\Service;

use Commonhelp\DI\ServiceProviderInterface;
use Commonhelp\DI\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerServiceProvider implements ServiceProviderInterface{
	
	private $file;
	
	public function __construct($logFile){
		$this->file = $logFile;
	}
	
	public function register(Container $container){
		$log = new Logger('commonhelp-log');
		$log->pushHandler(new StreamHandler($this->file, Logger::DEBUG));
		
		$container['log'] = $log;
	}
	
}