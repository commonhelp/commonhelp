<?php
namespace Commonhelp\Asset\Dependencies;

use Commonhelp\Asset\PackageInterface;
use Commonhelp\Event\EventDispatcherInterface;
use Commonhelp\ResourceLocator\UniformResourceLocator;

abstract class Dependencies implements DependenciesInterface{
	
	/**
	 * 
	 * @var PackageInterface
	 */
	protected $package;
	
	/**
	 * 
	 * @var EventDispatcherInterface
	 */
	protected $eventDispatcher;
	
	/**
	 * 
	 * @var UniformResourceLocator
	 */
	protected $locator;
	
	protected $dependencies;
	protected $queue;
	
	/**
	 * 
	 * @param PackageInterface $package
	 * @param EventDispatcherInterface $eventDispatcher
	 * @param UniformResourceLocator $locator
	 */
	public function __construct(PackageInterface $package, EventDispatcherInterface $eventDispatcher, UniformResourceLocator $locator){
		$this->package = $package;
		$this->eventDispatcher = $eventDispatcher;
		$this->dependencies = array();
		$this->locator = $locator;
		$this->queue = new \SplQueue();
	}
	
	public function getPackage(){
		return $this->package;
	}
	
	public function getEventDispatcher(){
		return $this->eventDispatcher;
	}
	
	public function add($handle, $dependencies=array(), $version=null){
		if(isset($this->dependencies[$handle])){
			return null;
		}
		
		$this->dependencies[$handle] = new Dependency($handle, $dependencies, $version);
	}
	
	public function remove($handle){
		if(isset($this->dependencies[$handle])){
			unset($this->dependencies[$handle]);
		}
	}
	
	public function get($handle){
		if(isset($this->dependencies[$handle])){
			return $this->dependencies[$handle];
		}
		
		return null;
	}
	
	public function has($handle){
		return isset($this->dependencies[$handle]);
	}
	
	public function hasInQueue($handle){
		foreach($this->queue as $queued){
			if($queued->getHandle() === $handle){
				return true;
			}
		}
		
		return false;
	}
	
	public function enqueue($handle, $dependencies=array(), $version=null){
		if(false === $this->has($handle)){
			$this->add($handle, $dependencies, $version);
		}
		$this->resolveDependencies($handle);
		if($this->hasInQueue($handle)){
			return null;
		}
		return $this->queue->enqueue($this->get($handle));
	}
	
	protected function resolveDependencies($handle){
		if(false === $this->has($handle)){
			return null;
		}
		
		$dependencies = $this->get($handle)->all();
		foreach($dependencies as $handle){
			$this->enqueue($handle);
		}
	}
	
	public function dequeue(){
		return $this->queue->dequeue();
	}
	
}