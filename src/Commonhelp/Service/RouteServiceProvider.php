<?php
namespace Commonhelp\Service;

use Commonhelp\DI\ServiceProviderInterface;
use Commonhelp\App\Routing\Router;
use Commonhelp\Config\Configurator\Configurator;
use Commonhelp\DI\ContainerInterface;


class RouteServiceProvider implements ServiceProviderInterface{
	
	
	public function register(ContainerInterface $container){
		$container->set('router', function($container){
			$locator = $container->get('locator');
			$configurator = $container->get('config');
			if($locator === null){
				throw new \RuntimeException('Locator must be initialized to use routers');
			}
			
			$resource = $locator->findResource('routes://system.json', true, true);
			$info = pathinfo($resource);
			return new Router($configurator->getParser($info['extension']), $resource, '/');
		});
	}
	
}