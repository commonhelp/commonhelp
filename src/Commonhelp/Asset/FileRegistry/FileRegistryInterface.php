<?php
namespace Commonhelp\Asset\FileRegistry;

interface FileRegistryInterface{
	
	public function get($handle);
	
	public function all();
	
	public function set($handle, $value);
	
	public function remove($handle);
	
}