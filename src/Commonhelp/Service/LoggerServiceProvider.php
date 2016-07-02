<?php
namespace Commonhelp\Service;

use Commonhelp\DI\ServiceProviderInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Commonhelp\DI\ContainerInterface;

class LoggerServiceProvider implements ServiceProviderInterface{
	
	private $file;
	
	public function __construct($logFile){
		$this->file = $logFile;
	}
	
	public function register(ContainerInterface $container){
		$log = new Logger('commonhelp-log');
		$log->pushHandler(new StreamHandler($this->file, Logger::DEBUG));
		
		$container->set('log', $log);
	}
	
}