<?php
namespace Commonhelp\Service;

use Commonhelp\DI\ServiceProviderInterface;
use Commonhelp\DI\Container;
use Commonhelp\App\Routing\Router;
use Commonhelp\Config\Configurator\Configurator;


class RouteServiceProvider implements ServiceProviderInterface{
	
	
	public function register(Container $container){
		$container['router'] = function($container){
			$locator = $container['locator'];
			$configurator = $container['config'];
			if($locator === null){
				throw new \RuntimeException('Locator must be initialized to use routers');
			}
			
			$resource = $locator->findResource('routes://system.json', true, true);
			$info = pathinfo($resource);
			return new Router($configurator->getParser($info['extension']), $resource, '/');
		};
	}
	
}