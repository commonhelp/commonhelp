<?php

namespace Commonhelp\Form;

use Commonhelp\Event\EventDispatcherInterface;
use Commonhelp\Event\EventSubscriberInterface;
use Commonhelp\Util\Inflector;
use Commonhelp\Form\DataTransformer\DataTransformerInterface;

abstract class FormBuilder{
	
	protected $element;
	protected $eventDispatcher;
	
	protected $action;
	protected $method;
	
	/**
	 * 
	 * @var FormCreator $creator
	 */
	protected $creator;
	
	private $modelTransformers = array();
	private $viewTransformers = array();
	
	protected $name;
	
	public function __construct(EventDispatcherInterface $eventDispatcher, $name = null){
		$this->name = $name;
		$this->eventDispatcher = $eventDispatcher;
		$this->method = 'POST';
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setCreator(FormCreator $creator){
	}
	
	public function setType(FormType $type){
		$this->element->setType($type);
	}
	
	public function setAttributes($attributes){
		foreach($attributes as $name => $value){
			$this->element->set($name, $value);
		}
	}
	
	public function getAction(){
		return $this->action;
	}
	
	public function setAction($action){
		$this->action = $action;
	}
	
	public function setMethod($method){
		$this->method = $method;
	}
	
	public function getMethod(){
		return $this->method;
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
	
	public function addModelTransformer(DataTransformerInterface $transformer, $forcedAppend = false){
		if($forcedAppend){
			$this->modelTransformers[] = $transformer;
		}else{
			array_unshift($this->modelTransformers, $transformer);
		}
	
		return $this;
	}
	
	public function resetModelTransformer(){
		$this->modelTransformers = array();
	
		return $this;
	}
	
	public function getModelTransformer(){
		return $this->modelTransformers;
	}
	
	public function addViewTransformer(DataTransformerInterface $transformer, $forcedPrepend = false){
		if($forcedPrepend){
			array_unshift($this->viewTransformers, $transformer);
		}else{
			$this->viewTransformers[] = $transformer;
		}
	
		return $this;
	}
	
	public function resetViewTransformer(){
		$this->viewTransformers = array();
	
		return $this;
	}
	
	public function getViewTransformer(){
		return $this->viewTransformers;
	}
	
}

?>