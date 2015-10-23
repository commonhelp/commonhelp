<?php
namespace Commonhelp\DI;

use Closure;
use Commonhelp\DI\Exception\QueryException;

/**
 * Class IContainer
 *
 * IContainer is the basic interface to be used for any internal dependency injection mechanism
 *
 */
interface IContainer {
	
	/**
	 * If a parameter is not registered in the container try to instantiate it
	 * by using reflection to find out how to build the class
	 * @param string $name the class name to resolve
	 * @return \stdClass
	 * @throws QueryException if the class could not be found or instantiated
	 */
	public function resolve($name);
	
	/**
	 * Look up a service for a given name in the container.
	 *
	 * @param string $name
	 * @return mixed
	*/
	public function query($name);
	
	/**
	 * A value is stored in the container with it's corresponding name
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return void
	*/
	public function registerParameter($name, $value);
	
	/**
	 * A service is registered in the container where a closure is passed in which will actually
	 * create the service on demand.
	 * In case the parameter $shared is set to true (the default usage) the once created service will remain in
	 * memory and be reused on subsequent calls.
	 * In case the parameter is false the service will be recreated on every call.
	 *
	 * @param string $name
	 * @param \Closure $closure
	 * @param bool $shared
	 * @return void
	*/
	public function registerService($name, Closure $closure, $shared = true);
	
	/**
	 * Shortcut for returning a service from a service under a different key,
	 * e.g. to tell the container to return a class when queried for an
	 * interface
	 * @param string $alias the alias that should be registered
	 * @param string $target the target that should be resolved instead
	*/
	public function registerAlias($alias, $target);
}