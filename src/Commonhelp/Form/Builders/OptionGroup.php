<?php

namespace Commonhelp\Form\Builders;

use Commonhelp\Form\FormBuilder;
use Commonhelp\Form\FormElement;
use Commonhelp\Event\EventDispatcherInterface;

class OptionGroup extends FormBuilder{
	
	public function __construct(EventDispatcherInterface $eventDispatcher){
		parent::__construct($eventDispatcher);
		$this->element = new FormElement('optgroup');
	}
	
}