<?php

namespace Commonhelp\Form;

use Commonhelp\Form\Builders\Form;
use Commonhelp\Form\Builders\Commonhelp\Form\Builders;
use Commonhelp\Util\Inflector;
use Commonhelp\Event\EventDispatcher;
use Commonhelp\App\Http\Request;
use Commonhelp\Form\RequestHandler\RequestHandlerInterface;
use Commonhelp\Form\RequestHandler\NativeRequestHandler;
use Commonhelp\Form\DataTransformer\DataTransformerInterface;
use Commonhelp\Form\DataTransformer\TransformFailedException;
use Commonhelp\Event\EventDispatcherInterface;

class FormCreator implements \ArrayAccess{
	
	/**
	 * 
	 * @var FormBuilder
	 */
	private $form;
	
	/**
	 * 
	 * @var FormElement
	 */
	private $formElement;
	
	/**
	 * 
	 * @var FormRegistry
	 */
	private $registry;
	
	private $modelData;
	private $normData;
	private $viewData;
	
	private $submitted = false;
	
	private $options;
	
	/**
	 * 
	 * @var RequestHandlerInterface
	 */
	private $requestHandler;
	
	/**
	 * 
	 * @param FormRegistry $registry
	 */
	public function __construct(FormRegistry $registry){
		$this->registry = $registry;
		$this->requestHandler = new NativeRequestHandler();
	}
	
	public function create($factory = null, $data=null, $options=array()){
		$this->form = new Form(new EventDispatcher());
		$this->formElement = $this->form->getFormElement();
		$this->formElement->setCreator($this);
		$this->modelData = $data;
		$this->options = $options;
		if(null !== $factory){
			$this->resolveFactory($factory)->buildForm($this, $this->getOptions());	
		}
		
		return $this;
	}
	
	public function add($name, $builder, $type = null, $options=array()){
		$this->formElement[$name] = array(
			'builder' => $this->generateBuilder($builder), 
			'type' => $this->generateType($type), 
			'options' => $options
		);
		
		return $this;
	}
	
	public function setAction($action){
		$this->form->setAction($action);
		return $this;
	}
	
	public function getAction(){
		return $this->form->getAction();
	}
	
	public function getName(){
		return $this->form->getName();
	}
	
	public function getMethod(){
		return $this->form->getMethod();
	}
	
	public function get($name){
		if($this->has($name)){
			return $this->formElement[$name];
		}
		
		return null;
	}
	
	public function remove($name){
		if($this->has($name)){
			unset($this->formElement[$name]);
		}
	}
	
	public function has($name){
		return isset($this->formElement[$name]) && $this->formElement[$name] instanceof FormBuilder;
	}
	
	public function createNamedBuilder($name, $builder, $type, $options){
		$type = $this->registry->getType($type);
		$builder = $this->registry->getBuilder($builder, $name, $type);
		$builder->setCreator($this);
		$options = array_merge($options, array('name' => $name));
		$builder->setAttributes($options);
		
		return $builder;
	}
	
	public function generateBuilder($builder){
		if(preg_match("/Builders\\\([^\d]+)/", $builder, $match)){
			return $builder;
		}
		return "\\Commonhelp\\Form\\Builders\\" . Inflector::classify($builder);
	}
	
	public function generateType($type){
		if($type === null){
			return null;
		}
		if(preg_match("/Types\\\([^\d]+)/", $type, $match)){
				return $type;
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
	
	public function getBuilder(){
		return $this->form;
	}
	
	/**
	 * @return EventDispatcherInterface
	 */
	public function getEventDispatcher(){
		return $this->form->getEventDispatcher();
	}
	
	public function offsetGet($child){
		return $this->get($child);
	}
	
	public function offsetSet($child, $value){
		throw new \RuntimeException('Could not set form children from FormCreator');
	}
	
	public function offsetUnset($child){
		$this->remove($child);
	}
	
	public function offsetExists($child){
		return $this->has($child);
	}
	
	public function handleRequest(Request $request){
		$this->requestHandler->handleRequest($this);
	}
	
	public function submit($submittedData, $clearMissing = true){
		$this->setData($submittedData);
		$this->submitted = true;
	}
	
	public function isSubmitted(){
		return $this->submitted;
	}
	
	public function addError($error){
		
	}
	
	public function getData(){
		return $this->modelData;	
	}
	
	public function getNormData(){
		return $this->normData;
	}
	
	public function getViewData(){
		return $this->viewData;
	}
	
	public function setData($modelData){
		$eventDispatcher = $this->getEventDispatcher();
		if($eventDispatcher->hasListeners(FormEvents::PRE_SET_DATA)){
			$event = new FormEvent($this->formElement, $modelData);
			$eventDispatcher->dispatch(FormEvents::PRE_SET_DATA, $event);
			$modelData = $event->getData();
		}
		
		if(!$this->form->getViewTransformer() && !$this->form->getModelTransformer() && is_scalar($modelData)){
			$modelData = (string) $modelData;
		}
		
		$normData = $this->modelToNorm($modelData);
		$viewData = $this->normToView($normData);
		
		$this->modelData = $modelData;
		$this->normData = $normData;
		$this->viewData = $viewData;
		
		if($eventDispatcher->hasListeners(FormEvents::POST_SET_DATA)){
			$event = new FormEvent($this, $modelData);
			$eventDispatcher->dispatch(FormEvents::POST_SET_DATA, $event);
		}
		
		return $this;
	}
	
	public function getOptions(){
		return $this->options;
	}
	
	private function resolveFactory($factory){
		if(class_exists($factory) && in_array('Commonhelp\Form\FormFactoryInterface', class_implements($factory))){
			return new $factory();
		}else{
			throw new \InvalidArgumentException(sprintf('Could not load form "%s"', $factory));
		}
	}
	
	private function normToModel($value){
		$transformers = $this->form->getModelTransformer();
		for($i = count($transformers) -1; $i >= 0; --$i){
			$value = $transformers[$i]->reverseTransform($value);
		}
	
		return $value;
	}
	
	private function modelToNorm($value){
		foreach($this->form->getModelTransformer() as $transformer){
			$value = $transformer->transform($value);
		}
	
		return $value;
	}
	
	private function normToView($value){
		if(empty($this->form->getViewTransformer())){
			return null === $value || is_scalar($value) ? (string) $value : $value;
		}
	
		foreach($this->form->getViewTransformer() as $transformer){
			$value = $transformer->transform($value);
		}
	
		return $value;
	}
	
	private function viewToNorm($value){
		if(empty($this->form->getViewTransformer())){
			return '' === $value ? null : $value;
		}
		$transformers = $this->form->getViewTransformer();
		for($i = count($transformers) -1; $i >= 0; --$i){
			$value = $transformers[$i]->reverseTransform($value);
		}
	
		return $value;
	}
	

	
	
	
}

?>