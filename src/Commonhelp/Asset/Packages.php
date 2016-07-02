<?php
namespace Commonhelp\Asset;

class Packages{
	
	private $defaultPackage;
	private $packages = array();
	
	/**
	 * 
	 * @param PackageInterface $defaultPackage
	 * @param array $packages
	 */
	public function __construct(PackageInterface $defaultPackage = null, array $packages = array()){
		$this->defaultPackage = $defaultPackage;
		
		foreach($packages as $name => $package){
			$this->addPackage($name, $package);
		}
	}
	
	public function setDefaultPackage(PackageInterface $defaultPackage){
		$this->defaultPackage = $defaultPackage;
	}
	
	public function addPackage($name, PackageInterface $package){
		$this->packages[$name] = $package;
	}
	
	public function getPackage($name = null){
		if(null === $name){
			if(null === $this->defaultPackage){
				throw new \LogicException('There is no default asset package, configure one first.');
			}
			
			return $this->defaultPackage;
		}
		
		if(!isset($this->packages[$name])){
			throw new \InvalidArgumentException(sprintf('There is no "%s" asset package.', $name));
		}
		
		return $this->packages[$name];
	}
	
	public function getVersion($path, $packageName = null){
		return $this->getPackage($packageName)->getVersion($path);
	}
	
	public function getUrl($path, $packageName = null){
		return $this->getPackage($packageName)->getUrl($path);
	}
	
}