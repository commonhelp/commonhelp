<?php
namespace Commonhelp\Asset\FileRegistry;

use Commonhelp\ResourceLocator\UniformResourceLocator;

class JavascriptRegistry extends FileRegistry{
	
	/**
	 * 
	 * @param UniformResourceLocator $locator
	 */
	public function __construct(UniformResourceLocator $locator){
		parent::__construct($locator);
		$this->findJavascriptFiles();
	}
	
	protected function findJavascriptFiles(){
		if(null === $dir = $this->getJavascriptDir()){
			return null;
		}
		
		$this->finder->files()->in($dir)->name('*.js');
		foreach($this->finder as $file){
			$name = preg_replace("/(.*).js/", "$1", $file->getFilename());
			$name = preg_replace("/(.*).min/", "$1", $name);
			$name = $this->convertName($name);
			$this->set($name, $file);
		}
	}
	
	protected function getJavascriptDir(){
		foreach($this->locator->getIterator('assets://', \FilesystemIterator::CURRENT_AS_FILEINFO) as $dir){
			if($dir->isDir() && $dir->getFilename() === 'js'){
				return $dir->getPathname();
			}
		}
		
		return null;
	}
	
	
}