<?php

namespace Commonhelp\Form;

use Commonhelp\Form\Builders\Form;
use Commonhelp\Form\Builders\Commonhelp\Form\Builders;
use Commonhelp\Util\Inflector;
use Commonhelp\Event\EventDispatcher;

class FormCreator{
	
	private $form;
	private $formElement;
	
	private $registry;
	
	public function __construct(){
		$this->form = new Form(new EventDispatcher());
		$this->formElement = $this->form->getFormElement();
		$this->formElement->setCreator($this);
		$this->registry = new FormRegistry();
	}
	
	public function add($name, $builder, $type = null, $options=array()){
		$this->formElement[$name] = array(
			'builder' => $this->generateBuilder($builder), 
			'type' => $this->generateType($type), 
			'options' => $options
		);
		
		return $this;
	}
	
	public function createNamedBuilder($name, $builder, $type, $options){
		$type = $this->registry->getType($type);
		$builder = $this->registry->getBuilder($builder, $type);
		$options = array_merge($options, array('name' => $name));
		$builder->setAttributes($options);
		
		return $builder;
	}
	
	public function generateBuilder($builder){
		return "\\Commonhelp\\Form\\Builders\\" . Inflector::classify($builder);
	}
	
	public function generateType($type){
		if($type === null){
			return null;
		}
		return "\\Commonhelp\\Form\\Types\\" . Inflector::classify($type) . "Type";
	}
	
	public function getForm(){
		$this->formElement->resolveChildern();
		return $this;
	}
	
	public function getElement(){
		return $this->formElement;
	}
	
	public function getEventDispatcher(){
		return $this->form->getEventDispatcher();
	}
	
}

?>