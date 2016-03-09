<?php
namespace Commonhelp\Service;

use Commonhelp\DI\ServiceProviderInterface;
use Commonhelp\DI\Container;
use Commonhelp\App\Routing\Router;
use Commonhelp\Config\Configurator\Configurator;


class RouteServiceProvider implements ServiceProviderInterface{
	
	
	public function register(Container $container){
		$container['routes'] = function($container){
			$locator = $container['locator'];
			$configurator = $container['config'];
			if($locator === null){
				throw new \RuntimeException('Locator must be initialized to use routers');
			}
			
			$resource = $locator->findResource('routes://routes.json', true, true);
			$info = pathinfo($resource);
			$router = new Router($configurator->getParser($info['extension']), $resource, '/');
			dump($router);
		};
	}
	
}