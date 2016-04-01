<?php
namespace Commonhelp\DI;

use Commonhelp\DI\Exception\InvalidArgumentException;
use Commonhelp\DI\Exception\DependencyException;
use Commonhelp\DI\Exception\FactoryNotFoundException;

class ComplexContainer extends SimpleContainer implements FactoryInterface{
	
	/**
	 * Build an entry of the container by its name.
	 *
	 * This method behave like get() except it forces the scope to "prototype",
	 * which means the definition of the entry will be re-evaluated each time.
	 * For example, if the entry is a class, then a new instance will be created each time.
	 *
	 * This method makes the container behave like a factory.
	 *
	 * @param string $name       Entry name or a class name.
	 * @param array  $parameters Optional parameters to use to build the entry. Use this to force specific parameters
	 *                           to specific values. Parameters not defined in this array will be resolved using
	 *                           the container.
	 *
	 * @throws InvalidArgumentException The name parameter must be of type string.
	 * @throws DependencyException Error while resolving the entry.
	 * @throws FactoryNotFoundException No entry found for the given name.
	 * @return mixed
	 */
	public function make($name, array $parameters = []){
	}
	
}