<?php

namespace Commonhelp\Form;

class Select extends FormBuilder{
	
	public function __construct(){
		$this->element = new FormElement('select');
	}
	
	public function addOption(Option $option){
		$this->element->addChild($option->getFormElement());
	}
	
	public function addOptionGroup($label, array $options){
		$optGroup = new OptionGroup();
		$optGroup->setAttributes(array('label' => $label));
		if(!empty($options)){
			foreach($options as $option){
				$optGroup->addOption($option->getFormElement());
			}
		}
		$this->element->addChild($optGroup->getFormElement());
	}
	
	public function getOptions(){
		return $this->options;
	}
	
	public function getOptionsGroups(){
		return $this->optionsGroups;
	}
	
}

?>