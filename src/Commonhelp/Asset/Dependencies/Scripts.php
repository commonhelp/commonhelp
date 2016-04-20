<?php
namespace Commonhelp\Asset\Dependencies;

use Commonhelp\Asset\PackageInterface;
use Commonhelp\Event\EventDispatcherInterface;
use Commonhelp\Asset\FileRegistry\JavascriptRegistry;

class Scripts extends Dependencies{
	
	private $inFooterQueue;
	
	/**
	 * 
	 * @param PackageInterface $package
	 * @param EventDispatcherInterface $eventDispatcher
	 * @param JavascriptRegistry $registry
	 */
	public function __construct(PackageInterface $package, EventDispatcherInterface $eventDispatcher, JavascriptRegistry $registry){
		parent::__construct($package, $eventDispatcher, $registry);
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
		$versionStrategy = $this->package->getVersionStrategy();
		$versionStrategy->setVersion($dependency->getVersion());
		$path = $this->registry->get($dependency->getHandle())->getRelativePathName();
		$src = $this->package->getUrl('js/'.$path);
		return sprintf("<script type=\"text/javascript\" src=\"%s\"></script>\n", $src);
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