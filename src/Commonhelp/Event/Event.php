<?php
namespace Commonhelp\Event;

class Event{
	private $propagationStopped = false;
	
	public function isPropagationStopped(){
		return $this->propagationStopped;
	}
	
	public function stopPropagation(){
		$this->propagationStopped = true;
	}
}

?>