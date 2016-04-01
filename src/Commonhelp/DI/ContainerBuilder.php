<?php
namespace Commonhelp\DI;

class ContainerBuilder{
	
	private $containerClass;
	
	private $useAutowiring = true;
	
	private $useAnnotations = false;
	
	private $ignorePhpDocErrors = false;
	
	private $cache;
	
	private $definitionSources = array();
	
	private $writeProxysToFile = false;
	
	private $proxyDirectory;
	
	public function __construct($containerClass = 'ComplexContainer'){
		$this->containerClass = $containerClass;
	}
	
	/**
	 * 
	 * @return ContainerInterface
	 */
	public function build(){
		
	}
	
	/**
	 * 
	 * @param bool $bool
	 * @return \Commonhelp\DI\ContainerBuilder
	 */
	public function useAutowiring($bool){
		$this->useAutowiring = $bool;
		return $this;
	}
	
	/**
	 * 
	 * @param bool $bool
	 * @return \Commonhelp\DI\ContainerBuilder
	 */
	public function useAnnotations($bool){
		$this->useAnnotations = $bool;
		return $this;
	}
	
	/**
	 * @param bool $bool
	 * @return \Commonhelp\DI\ContainerBuilder
	 */
	public function ignorePhpDocErrors($bool){
		$this->ignorePhpDocErrors = $bool;
		return $this;
	}
	
	/**
	 * 
	 * @param bool $writeToFile
	 * @param string $proxyDirectory
	 * @throws InvalidArgumentException
	 * @return \Commonhelp\DI\ContainerBuilder
	 */
	public function writeProxiesToFile($writeToFile, $proxyDirectory = null){
		$this->writeProxysToFile = $writeToFile;
		
		if($writeToFile && $proxyDirectory === null){
			throw new InvalidArgumentException('The proxy directory must be specified if you want to write proxies on disk');
		}
		
		$this->proxyDirectory = $proxyDirectory;
		
		return $this;
	}
	
	public function addDefinitions($definitions){
		
		return $this;
	}
	
	
}