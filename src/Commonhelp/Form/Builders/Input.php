<?php

namespace Commonhelp\Form\Builders;

use Commonhelp\Form\FormBuilder;
use Commonhelp\Form\FormElement;
use Commonhelp\Event\EventDispatcherInterface;

class Input extends FormBuilder{
	
	public function __construct(EventDispatcherInterface $eventDispatcher, $name = null){
		parent::__construct($eventDispatcher, $name);
		$this->element = new FormElement('input');
	}
	
}

?>