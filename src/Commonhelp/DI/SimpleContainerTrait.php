<?php
namespace Commonhelp\DI;

trait SimpleContainerTrait{
	
	protected $container;
	
	public function setContainer(SimpleContainer $container=null){
		$this->container = $container;
	}
	
}