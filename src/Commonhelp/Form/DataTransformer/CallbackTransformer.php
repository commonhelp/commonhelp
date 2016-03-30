<?php
namespace Commonhelp\Form\DataTransformer;

class CallbackTransformer implements DataTransformerInterface{
	
	/**
	 * The callback used for forward transform.
	 *
	 * @var callable
	 */
	private $transform;
	
	/**
	 * The callback used for reverse transform.
	 *
	 * @var callable
	 */
	private $reverseTransform;
	
	/**
	 * Constructor.
	 *
	 * @param callable $transform        The forward transform callback
	 * @param callable $reverseTransform The reverse transform callback
	 */
	public function __construct(callable $transform, callable $reverseTransform){
		$this->transform = $transform;
		$this->reverseTransform = $reverseTransform;
	}
	
	/**
	 * Transforms a value from the original representation to a transformed representation.
	 *
	 * @param mixed $data The value in the original representation
	 *
	 * @return mixed The value in the transformed representation
	 *
	 * @throws TransformFailedException when tranform fail
	 */
	public function transform($data){
		return call_user_func($this->transform, $data);
	}
	
	/**
	 * Transforms a value from the transformed representation to its original
	 * representation.
	 *
	 * @param mixed $data The value in the transformed representation
	 *
	 * @return mixed The value in the original representation
	 *
	 * @throws TransformFailedException when the transformation fails
	 */
	public function reverseTransform($data){
		return call_user_func($this->reverseTransform, $data);
	}
	
}