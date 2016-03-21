<?php
namespace Commonhelp\Asset\FileRegistry;

use Commonhelp\ResourceLocator\UniformResourceLocator;

class LessRegistry extends FileRegistry{
	
	/**
	 * 
	 * @param UniformResourceLocator $locator
	 */
	public function __construct(UniformResourceLocator $locator){
		parent::__construct($locator);
		$this->findLessFiles();
	}
	
	protected function findLessFiles(){
		if(null === $dir = $this->getLessDir()){
			return null;
		}
		
		$this->finder->files()->in($dir)->name('*.less');
		foreach($this->finder as $file){
			$name = preg_replace("/(.*).less/", "$1", $file->getFilename());
			$name = $this->convertName($name);
			$this->set($name, $file);
		}
	}
	
	protected function getLessDir(){
		foreach($this->locator->getIterator('assets://', \FilesystemIterator::CURRENT_AS_FILEINFO) as $dir){
			if($dir->isDir() && $dir->getFilename() === 'less'){
				return $dir->getPathname();
			}
		}
	
		return null;
	}
	
}