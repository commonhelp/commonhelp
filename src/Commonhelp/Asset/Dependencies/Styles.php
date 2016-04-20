<?php
namespace Commonhelp\Asset\Dependencies;

use Commonhelp\Asset\PackageInterface;
use Commonhelp\Event\EventDispatcherInterface;
use Commonhelp\Asset\FileRegistry\StylesheetRegistry;
use Commonhelp\Asset\FileRegistry\LessRegistry;

class Styles extends Dependencies{
	
	private $textDirection = 'ltr';
	
	/**
	 * 
	 * @var LessRegistry $less
	 */
	private $less = null;
	
	/**
	 * 
	 * @param PackageInterface $package
	 * @param EventDispatcherInterface $eventDispatcher
	 * @param StylesheetRegistry $registry
	 */
	public function __construct(PackageInterface $package, EventDispatcherInterface $eventDispatcher, StylesheetRegistry $registry, LessRegistry $less){
		parent::__construct($package, $eventDispatcher, $registry);
		$this->less = $less;
	}
	
	public function defaultStyles(){
		$this->eventDispatcher->dispatch(DependenciesEvents::DEFAULT_STYLES, new DependenciesEvent($this));
	}
	
	public function getTextDirection(){
		return $this->textDirection;
	}
	
	public function setRightToLeftTextDirection(){
		$this->textDirection = 'rtl';
	}
	
	public function setLeftToRightTextDirection(){
		$this->textDirection = 'ltr';
	}
	
	public function printStyle(Dependency $dependency){
		$versionStrategy = $this->package->getVersionStrategy();
		$versionStrategy->setVersion($dependency->getVersion());
		$path = $this->registry->get($dependency->getHandle())->getRelativePathName();
		$src = $this->package->getUrl('css/'.$path);
		return sprintf("<link rel=\"stylesheet\" href=\"%s\">", $src);
	}
	
	protected function printInlineStyle($style){
		return sprintf("<style type=\"text/css\">\n%s\n</style>\n", $style);
	}
	
	public function printLess(Dependency $dependency){
		$versionStrategy = $this->package->getVersionStrategy();
		$versionStrategy->setVersion($dependency->getVersion());
		if($this->less->get($dependency->getHandle()) === null){
			return $this->printStyle($dependency);
		}
		
		$pathObj = $this->less->get($dependency->getHandle());
		$compiler = new \lessc();
		return $this->printInlineStyle($compiler->compileFile($pathObj->getPathName()));
	}
	
	public function dequeue(){
		$dependency = parent::dequeue();
		return $this->printStyle($dependency);
	}
	
	public function lessdequeue(){
		$dependency = parent::dequeue();
		return $this->printLess($dependency);
	}
	
}