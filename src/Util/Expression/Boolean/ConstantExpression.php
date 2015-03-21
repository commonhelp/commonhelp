<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Context;

class ConstantExpression extends TerminalExpression{
	
	protected $validConstants = array('true', 'false');
	
	public function __construct($constant){
		if(!in_array($constant, $this->validConstants)){
			throw new \RuntimeException('Invalid constant: only true and false are admitted');
		}
		$this->value = $constant;
		$this->left = null;
		$this->right = null;
		
	}
	
	public function stringfy(Context $context){
		return $context->toString($this);
	}
	
}