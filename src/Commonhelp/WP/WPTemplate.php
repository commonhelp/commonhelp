<?php
namespace Commonhelp\WP;

use Commonhelp\App\Template\TemplateBase;
use Commonhelp\App\Template\TemplateFileLocator;
use Commonhelp\App\Exception\TemplateNotFoundException;
use Commonhelp\App\AbstractController;

class WPTemplate extends TemplateBase{

	private $templateDirs;

	private $controller;

	private $methodName;

	public function __construct(WPIController $controller, $methodName=null){
		$this->templateDirs = $controller->getTemplateDirs();
		if(is_null($methodName)){
			$this->methodName = $controller->getAction();
		}else{
			$this->methodName = $methodName;
		}
		$this->controller = $controller;
		list($path, $name) = $this->findTemplate($controller->getAppName(), $this->methodName);
		$this->path = $path;
		$this->template = $name;
	}

	public function setTemplateDirs(array $templateDirs){
		$this->templateDirs = $templateDirs;
	}

	public function getTemplateDirs(){
		return $this->templateDirs;
	}

	protected function findTemplate($app, $name){
		if( $app !== '' ) {
			$dirs = $this->getWPAppTemplateDirs($app);
		} else {
			$dirs = $this->getWPCoreTemplateDirs();
		}
		$locator = new TemplateFileLocator($dirs);
		$template = $locator->find($name);
		$path = $locator->getPath();

		return array($path, $template);
	}

	public function inc($template, $additionalParams){

	}

	public static function renderError(AbstractController $controller, $error_msg){
		try{
			if(!is_null($controller)){
				$c = clone($controller);
				$c->setAppName('error');
			}else{

			}
			$content = new WPTemplate($c, 'error');
			$content->assign('error', $error_msg);
			return $content->render();
		}catch(TemplateNotFoundException $ex){
			header(self::getHttpProtocol() . ' 500 Internal Server Error');
			header('Content-Type: text/plain; charset=utf-8');
			print("$error_msg");
			die();
		}
	}

	public static function renderException(AbstractController $controller, \Exception $exception){
		try{
			$c = clone($controller);
			$c->setAppName('errorApp');
			$content = new WPTemplate($c, 'exception');
			$content->assign('errorClass', get_class($exception));
			$content->assign('errorMsg', $exception->getMessage());
			$content->assign('errorCode', $exception->getCode());
			$content->assign('errorFile', $exception->getFile());
			$content->assign('line', $exception->getLine());
			$content->assign('trace', $exception->getTraceAsString());
			return $content->render();
		}catch(TemplateNotFoundException $ex){
			header(self::getHttpProtocol() . ' 500 Internal Server Error');
			header('Content-Type: text/plain; charset=utf-8');
			print("Internal Server Error\n\n");
			print("The server encountered an internal error and was unable to complete your request.\n");
			print(get_class($exception).': '.$exception->getMessage()."\n\n");
			print($exception->getTraceAsString());
			die();
		}
	}

	private function getWPAppTemplateDirs($app){
		if(!empty($this->templateDirs)){
			$dirs = array();
			foreach($this->templateDirs as $tDir){
				$appFolder = TemplateFileLocator::getAppFolder($app);
				$dirs[] = "{$tDir}/templates/{$appFolder}/";
			}
			return $dirs;
		}

		return array(
			WPApplication::$APPPATH.'/templates/'.TemplateFileLocator::getAppFolder($app)
		);

	}

	private function getWPCoreTemplateDirs(){
		if(!empty($this->templateDirs)){
			$dirs = array();
			foreach($this->templateDirs as $tDir){
				$dirs[] = "{$tDir}/templates/";
			}

			return $dirs;
		}

		return array(
				WPApplication::$APPPATH.'/templates'
		);
	}

}
