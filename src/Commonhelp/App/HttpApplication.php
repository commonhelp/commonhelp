<?php
namespace Commonhelp\App;

use Commonhelp\App\Exception\ControllerNotFoundException;
use Commonhelp\App\Http\CallbackResponse;
use Commonhelp\DI\SimpleContainer;

class HttpApplication extends AbstractApplication{
	
	protected $appName;
	protected $webRoot;
	
	public function __construct($appName, $webRoot, ApplicationContainer $container){
		$this->appName = $appName;
		$this->container = $container;
		$this->webRoot = $webRoot;
	}
	
	public static function main($controllerName, $methodName, SimpleContainer $container, array $urlParams = null){
		if(!is_null($urlParams)){
			$container['Request']->setUrlParameters($urlParams);
		} else if (isset($container['urlParams']) && !is_null($container['urlParams'])){
			$container['Request']->setUrlParameters($container['urlParams']);
		}
		$appName = $container['appName'];
		try {
			$controller = $container->query($controllerName);
		} catch(QueryException $e) {
			throw new ControllerNotFoundException($controllerName.' is not registered');
		}
		// initialize the dispatcher and run all the middleware before the controller
		$dispatcher = $container['Dispatcher'];
		list(
				$httpHeaders,
				$responseHeaders,
				$responseCookies,
				$output,
				$response
		) = $dispatcher->dispatch($controller, $methodName);
		$io = $container['Output'];
		if(!is_null($httpHeaders)) {
			$io->setHeader($httpHeaders);
		}
		foreach($responseHeaders as $name => $value) {
			$io->setHeader($name . ': ' . $value);
		}
		foreach($responseCookies as $name => $value) {
			$expireDate = null;
			if($value['expireDate'] instanceof \DateTime) {
				$expireDate = $value['expireDate']->getTimestamp();
			}
			$io->setCookie(
					$name,
					$value['value'],
					$expireDate,
					$this->webRoot,
					null,
					$container->getRequest()->getServerProtocol() === 'https',
					true
			);
		}
		if ($response instanceof CallbackResponse) {
			$response->callback($io);
		} else if(!is_null($output)) {
			$io->setHeader('Content-Length: ' . strlen($output));
			$io->setOutput($output);
		}
	}
	
	public static function part($controllerName, $methodName, SimpleContainer $container, array $urlParams = null){
		if (!is_null($urlParams)) {
			$container['Request']->setUrlParameters($urlParams);
		} else if (isset($container['urlParams']) && !is_null($container['urlParams'])) {
			$container['Request']->setUrlParameters($container['urlParams']);
		}
		$controller = $container[$controllerName];
		$dispatcher = $container['Dispatcher'];
		list(, , $output) =  $dispatcher->dispatch($controller, $methodName);
		return $output;
	}
	
}