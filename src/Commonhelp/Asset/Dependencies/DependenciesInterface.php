<?php
namespace Commonhelp\Asset\Dependencies;

interface DependenciesInterface{
	
	public function add($handle, $dependencies=array(), $version=null);
	
	public function remove($handle);
	
	
	/**
	 * Queue an item or items.
	 *
	 * Decodes handles and arguments, then queues handles and stores
	 * arguments in the class property $args. For example in extending
	 * classes, $args is appended to the item url as a query string.
	 * Note $args is NOT the $args property of items in the $registered array.
	 *
	 * @access public
	 *
	 */
	public function enqueue($handle, $dependencies=array(), $version=null);
	
	/**
	 * Dequeue an item or items.
	 *
	 * Decodes handles and arguments, then dequeues handles
	 * and removes arguments from the class property $args.
	 *
	 * @access public
	 *
	 */
	public function dequeue();
	
		
}