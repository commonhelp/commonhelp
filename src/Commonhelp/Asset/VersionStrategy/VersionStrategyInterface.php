<?php
namespace Commonhelp\Asset\VersionStrategy;

interface VersionStrategyInterface{
	
	/**
	 * Returns the asset version for an asset.
	 *
	 * @param string $path A path
	 *
	 * @return string The version string
	 */
	public function getVersion($path);
	
	public function setVersion($version);
	
	/**
	 * Applies version to the supplied path.
	 *
	 * @param string $path A path
	 *
	 * @return string The versionized path
	 */
	public function applyVersion($path);
	
}