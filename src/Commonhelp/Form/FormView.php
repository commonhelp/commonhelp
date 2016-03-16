<?php
namespace Commonhelp\Form;

use Commonhelp\App\Template\TemplateBase;
use Commonhelp\App\Template\TemplateInterface;

class FormView{
	
	private $engine;
	
	/**
	 * 
	 * @param TemplateInterface $engine
	 */
	public function __construct(TemplateInterface $engine){
		$this->engine = $engine;
		$this->engine->setApplication('form');
	}
	
	public function render(FormCreator $form){
		$formEl = $form->getElement();
		$dispatcher = $form->getEventDispatcher();
		$fEventBeforeForm = $dispatcher->dispatch(FormEvents::BEFORE_FORM, new FormEvent($formEl, array()));
		$formHtml = $this->engine->inc('start', array('attributes' => $formEl->all(), 'before' => $fEventBeforeForm));
		foreach($formEl->getIterator() as $name => $children){
			$tName = $children->getFormElement()->getType()->getTemplate();
			$fEventBeforeLabel = $dispatcher->dispatch(FormEvents::BEFORE_LABEL, new FormEvent($formEl, array()));
			$fEventAfterLabel = $dispatcher->dispatch(FormEvents::AFTER_LABEL, new FormEvent($formEl, array()));
			if($tName === 'choiche'){
				$formHtml .= $this->engine->inc('label_start', array('element' => $children->getFormElement(), 'before' => $fEventBeforeLabel));
			}else{
				$formHtml .= $this->engine->inc('label_start', array('element' => $children->getFormElement(), 'before' => $fEventBeforeLabel));
				$formHtml .= $this->engine->inc('label_end', array('after' => $fEventAfterLabel));
			}
			$fEventBefore = $dispatcher->dispatch(FormEvents::BEFORE_FIELD, new FormEvent($formEl, array()));
			$fEventAfter = $dispatcher->dispatch(FormEvents::AFTER_FIELD, new FormEvent($formEl, array()));
			$formHtml .= $this->engine->inc(
				$tName, 
				array(
					'element' => $children->getFormElement(),
					'before' => $fEventBefore,
					'after' => $fEventAfter
				)
			);
			if($tName === 'choiche'){
				$formHtml .= $this->engine->inc('label_end', array('after' => $fEventAfterLabel));
			}
		}
		$fEventAfterForm = $dispatcher->dispatch(FormEvents::AFTER_FORM, new FormEvent($formEl, array()));
		$formHtml .= $this->engine->inc('end', array('after' => $fEventAfterForm));
		return $formHtml;
	}
	
}