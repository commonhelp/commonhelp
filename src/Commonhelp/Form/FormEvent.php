<?php
namespace Commonhelp\Form;

use Commonhelp\Event\Event;

class FormEvent extends Event{
	
	private $form;
	protected $data;
	
	public function construct(FormElement $form, $data){
		$this->form = $form;
		$this->data = $data;
	}
	
	public function getForm(){
		return $this->form;
	}
	
	public function getData(){
		return $this->data;
	}
	
}