<?php

namespace Commonhelp\App\Template;

use Commonhelp\App\AbstractController;
abstract class TemplateBase{
	
	protected $template;
	protected $vars;
	
	protected $path;
	
	public function __construct($template=null){
		$this->vars = array();
		$this->template = $template;
	}
	
	public function setTemplate(){
		$this->template = $template;
	}
	
	public function getTemplate(){
		return $this->template;
	}
	
	public function setVars(array $vars){
		$this->vars = $vars;
	}
	
	public function getVars(){
		return $this->vars;
	}
	
	public function render(){
		return $this->load($this->template);
	}
	
	public function assign( $key, $value) {
		$this->vars[$key] = $value;
		return true;
	}
	
	protected function load($file, $vars=array()){
		//Register variable
		if(empty($vars)){
			extract($this->vars);
		}else{
			extract($vars);
		}
		
		ob_start();
		include $file;
		$data = ob_get_contents();
		@ob_end_clean();
		// Return data
		return $data;
	}
	
	protected static function getHttpProtocol() {
		$claimedProtocol = strtoupper($_SERVER['SERVER_PROTOCOL']);
		$validProtocols = [
				'HTTP/1.0',
				'HTTP/1.1',
				'HTTP/2',
		];
		if(in_array($claimedProtocol, $validProtocols, true)) {
			return $claimedProtocol;
		}
		return 'HTTP/1.1';
	}
	
	abstract protected function findTemplate($app, $name);
	
	abstract public function inc($template, $additionalParams);
	
	abstract public static function renderError(AbstractController $controller, $error_msg);
	abstract public static function renderException(AbstractController $controller, \Exception $exception);
	
}