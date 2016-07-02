<?php
namespace Commonhelp\Asset\FileRegistry;

use Commonhelp\ResourceLocator\UniformResourceLocator;

class ImageRegistry extends FileRegistry{
	
	/**
	 * 
	 * @param UniformResourceLocator $locator
	 */
	public function __construct(UniformResourceLocator $locator){
		parent::__construct($locator);
		$this->findImageFiles();
	}
	
	public function findImageFiles(){
		
	}
	
}