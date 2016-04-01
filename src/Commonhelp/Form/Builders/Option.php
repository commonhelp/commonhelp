<?php

namespace Commonhelp\Form\Builders;

use Commonhelp\Form\FormBuilder;
use Commonhelp\Form\FormElement;
use Commonhelp\Event\EventDispatcherInterface;

class Option extends FormBuilder{
	
	public function __construct(EventDispatcherInterface $eventDispatcher, $name = null){
		parent::__construct($eventDispatcher);
		$this->element = new FormElement('option');
	}
	
}