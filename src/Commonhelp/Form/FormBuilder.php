<?php

namespace Commonhelp\Form;

use Commonhelp\Event\EventDispatcherInterface;
use Commonhelp\Event\EventSubscriberInterface;

abstract class FormBuilder{
	
	protected $element;
	protected $eventDispatcher;
	
	public function __construct(EventDispatcherInterface $eventDispatcher){
		$this->eventDispatcher = $eventDispatcher;
	}
	
	public function setType(FormType $type){
		$this->element->setType($type);
	}
	
	public function setAttributes($attributes){
		foreach($attributes as $name => $value){
			$this->element->set($name, $value);
		}
	}
	
	public function getFormElement(){
		return $this->element;
	}
	
	public function addEventListener($eventName, $listener, $priority = 0){
		$this->eventDispatcher->addListener($eventName, $listener, $priority);
		return $this;
	}
	
	public function addEventSubscriber(EventSubscriberInterface $subscriber){
		$this->eventDispatcher->addSubscriber($subscriber);
		return $this;
	}
	
	public function getEventDispatcher(){
		return $this->eventDispatcher;
	}
	
}

?>