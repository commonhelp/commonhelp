<?php
namespace Commonhelp\Asset\VersionStrategy;

class EmptyVersionStrategy implements VersionStrategyInterface{
	
	public function getVersion($path){
		return '';
	}
	
	public function setVersion($version){
		return false;
	}
	
	public function applyVersion($path){
		return '';
	}
	
}