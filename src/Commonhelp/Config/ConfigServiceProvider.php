<?php
namespace Commonhelp\Config;

use Commonhelp\DI\ServiceProviderInterface;
use Commonhelp\DI\Container;
class ConfigServiceProvider implements ServiceProviderInterface{

	public function register(Container $c){
		$c['config'] = new Config();
	}
	
}