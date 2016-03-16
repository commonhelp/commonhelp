<?php
namespace Commonhelp\Asset\Dependencies;

use Commonhelp\Asset\PackageInterface;
use Commonhelp\Event\EventDispatcherInterface;
use Commonhelp\ResourceLocator\UniformResourceLocator;

class Scripts extends Dependencies{
	
	private $inFooterQueue;
	
	/**
	 * 
	 * @param PackageInterface $package
	 * @param EventDispatcherInterface $eventDispatcher
	 * @param UniformResourceLocator $locator
	 */
	public function __construct(PackageInterface $package, EventDispatcherInterface $eventDispatcher, UniformResourceLocator $locator){
		parent::__construct($package, $eventDispatcher, $locator);
		$this->inFooterQueue = new \SplQueue();
	}
	
	public function defaultScripts(){
		$this->eventDispatcher->dispatch(DependenciesEvents::DEFAULT_SCRIPTS, new DependenciesEvent($this));
	}
	
	public function printExtraScripts(){
		return "<script type=\"text/javascript\">\n/* <![CDATA[ */\n {$output}\n/* ]]> */\n</script>\n";
	}
	
	public function printInlineScript(){
		return sprintf("<script type=\"text/javascript\">\n%s\n</script>", $output);
	}
	
	public function printScript(Dependency $dependency){
		$this->setSources('js');
		return $dependency->getHandle();
	}
	
	public function enqueueInFooter($handle, $dependencies=array(), $version=null){
		if(false === $this->has($handle)){
			$this->add($handle, $dependencies, $version);
		}
		$this->resolveDependencies($handle);
		if($this->hasInQueue($handle)){
			return null;
		}
		return $this->inFooterQueue->enqueue($this->get($handle));
	}
	
	public function dequeueInFooter(){
		$dependency = $this->inFooterQueue->dequeue();
		
		return $this->printScript($dependency);
	}
	
	public function dequeue(){
		$dependency = parent::dequeue();
		
		return $this->printScript($dependency);
	}
	
}