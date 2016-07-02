<?php
namespace Commonhelp\Form;

use Commonhelp\App\Template\TemplateBase;
use Commonhelp\App\Template\TemplateInterface;

class FormView{
	
	private $engine;
	
	private $defaultOptions = array(
		'label' => false
	);
	
	/**
	 * 
	 * @param TemplateInterface $engine
	 */
	public function __construct(TemplateInterface $engine){
		$this->engine = $engine;
		$this->engine->setApplication('form');
	}
	
	public function render(FormCreator $form, $options=array()){
		$options = array_merge($options, $this->defaultOptions);
		$formHtml = $this->renderStart($form->getBuilder());
		foreach($form->getElement()->getIterator() as $name => $children){
			$formHtml .= $this->renderErrors($children);
			if($options['label']){
				$formHtml .= $this->renderLabel($children);
			}
			$formHtml .= $this->renderWidget($children);
		}
		$formHtml .= $this->renderEnd($form->getBuilder());
		return $formHtml;
	}
	
	public function renderStart(FormBuilder $form){
		$formEl = $form->getFormElement();
		$dispatcher = $form->getEventDispatcher();
		$fEventBeforeForm = $dispatcher->dispatch(FormEvents::BEFORE_FORM, new FormEvent($formEl, array()));
		$fEventBeforeFieldset = $dispatcher->dispatch(FormEvents::BEFORE_FIELDSET, new FormEvent($formEl, array()));
		return $this->engine->inc('start',
			array(
				'attributes' => $formEl->all(), 
				'action' => $form->getAction(),
				'method' => $form->getMethod(),
				'before' => $fEventBeforeForm, 
				'before_fieldset' => $fEventBeforeFieldset
			)
		);
	}
	
	public function renderEnd(FormBuilder $form){
		$formEl = $form->getFormElement();
		$dispatcher = $form->getEventDispatcher();
		$fEventAfterForm = $dispatcher->dispatch(FormEvents::AFTER_FORM, new FormEvent($formEl, array()));
		$fEventAfterFieldset = $dispatcher->dispatch(FormEvents::AFTER_FIELDSET, new FormEvent($formEl, array()));
		return $this->engine->inc('end',
				array('after' => $fEventAfterForm, 'after_fieldset' => $fEventAfterFieldset));
	}
	
	public function renderWidget(FormBuilder $form){
		$formEl = $form->getFormElement();
		$tName = $formEl->getType()->getTemplate();
		$dispatcher = $form->getEventDispatcher();
		$fEventBefore = $dispatcher->dispatch(FormEvents::BEFORE_FIELD, new FormEvent($formEl, array()));
		$fEventAfter = $dispatcher->dispatch(FormEvents::AFTER_FIELD, new FormEvent($formEl, array()));
		return $this->engine->inc(
				$tName,
				array(
						'element' => $formEl,
						'before' => $fEventBefore,
						'after' => $fEventAfter
				)
		);
	}
	
	public function renderRow(FormBuilder $form){
		return $this->renderErrors($form) . $this->renderLabel($form) . $this->renderWidget($form);
	}
	
	public function renderLabel(FormBuilder $form){
		$formEl = $form->getFormElement();
		$dispatcher = $form->getEventDispatcher();
		$fEventBeforeLabel = $dispatcher->dispatch(FormEvents::BEFORE_LABEL, new FormEvent($formEl, array()));
		$fEventAfterLabel = $dispatcher->dispatch(FormEvents::AFTER_LABEL, new FormEvent($formEl, array()));
		return $this->engine->inc(
			'label', 
			array(
				'element' => $formEl, 
				'before' => $fEventBeforeLabel,
				'after' => $fEventAfterLabel
			)
		);
	}
	
	public function renderErrors(FormBuilder $form){
		return '';
	}
	
}