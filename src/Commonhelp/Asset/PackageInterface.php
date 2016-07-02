<?php
namespace Commonhelp\Asset;

interface PackageInterface{
	
	/**
	 * Returns the asset version for an asset.
	 *
	 * @param string $path A path
	 *
	 * @return string The version string
	 */
	public function getVersion($path);
	
	/**
	 * Returns an absolute or root-relative public path.
	 *
	 * @param string $path A path
	 *
	 * @return string The public path
	 */
	public function getUrl($path);
	
}