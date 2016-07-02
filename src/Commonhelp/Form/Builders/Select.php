<?php

namespace Commonhelp\Form\Builders;

use Commonhelp\Form\FormBuilder;
use Commonhelp\Form\FormElement;
use Commonhelp\Event\EventDispatcherInterface;
use Commonhelp\Form\FormType;
use Commonhelp\Form\Types\OptionType;
use Commonhelp\Form\FormCreator;

class Select extends FormBuilder{
	
	public function __construct(EventDispatcherInterface $eventDispatcher, $name = null){
		parent::__construct($eventDispatcher, $name);
		$this->element = new FormElement('select');
	}
	
	public function setAttributes($attributes){
		if(isset($attributes['options']) && !empty($attributes['options'])){
			$options = $attributes['options'];
			unset($attributes['options']);
		}else{
			$options = array();
		}
		$this->createOptions($options);
		parent::setAttributes($attributes);
	}
	
	public function setCreator(FormCreator $creator){
		$this->element->setCreator($creator);
	}
	
	protected function createOptions($options){
		foreach($options as $value => $option){
			if(is_array($option)){
				
			}else{
				$this->element[$value] = array(
					'builder' => Option::class,
					'type' => OptionType::class,
					'options' => array('value' => $value, 'text' => $option)
				);
			}
		}
		
		$this->element->resolveChildern();
	}
	
}

?>