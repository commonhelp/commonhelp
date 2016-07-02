<?php
namespace Commonhelp\Asset\Context;

interface ContextInterface{
	
	/**
	 * Gets the base path.
	 *
	 * @return string The base path
	 */
	public function getBasePath();
	
	/**
	 * Checks whether the request is secure or not.
	 *
	 * @return bool true if the request is secure, false otherwise
	*/
	public function isSecure();
	
}