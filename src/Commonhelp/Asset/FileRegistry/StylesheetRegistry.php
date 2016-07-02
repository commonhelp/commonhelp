<?php
namespace Commonhelp\Asset\FileRegistry;

use Commonhelp\ResourceLocator\UniformResourceLocator;

class StylesheetRegistry extends FileRegistry{
	
	/**
	 * 
	 * @param UniformResourceLocator $locator
	 */
	public function __construct(UniformResourceLocator $locator){
		parent::__construct($locator);
		$this->findStylesheetFiles();
	}
	
	protected function findStylesheetFiles(){
		if(null === $dir = $this->getStylesheetDir()){
			return null;
		}
		
		$this->finder->files()->in($dir)->name('*.css');
		foreach($this->finder as $file){
			$name = preg_replace("/(.*).css/", "$1", $file->getFilename());
			$name = preg_replace("/(.*).min/", "$1", $name);
			$name = $this->convertName($name);
			$this->set($name, $file);
		}
	}
	
	protected function getStylesheetDir(){
		foreach($this->locator->getIterator('assets://', \FilesystemIterator::CURRENT_AS_FILEINFO) as $dir){
			if($dir->isDir() && $dir->getFilename() === 'css'){
				return $dir->getPathname();
			}
		}
	
		return null;
	}
	
}