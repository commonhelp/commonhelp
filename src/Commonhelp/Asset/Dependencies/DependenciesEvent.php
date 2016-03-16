<?php
namespace Commonhelp\Asset\Dependencies;

use Commonhelp\Event\Event;

class DependenciesEvent extends Event{
	
	private $dependencies;
	
	public function __construct(DependenciesInterface $dependencies){
		$this->dependencies = $dependencies;
	}
	
	public function getDependencies(){
		return $this->dependencies;
	}
	
}