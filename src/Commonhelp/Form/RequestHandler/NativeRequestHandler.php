<?php
namespace Commonhelp\Form\RequestHandler;

use Commonhelp\Util\Http\ServerParams;
use Commonhelp\Form\FormCreator;

class NativeRequestHandler implements RequestHandlerInterface{
	
	/**
	 * 
	 * @var ServerParams
	 */
	private $serverParams;
	
	public function __construct(ServerParams $params = null){
		$this->serverParams = $params ?: new ServerParams();
	}
	
	private static $fileKeys = array(
		'error',
		'name',
		'size',
		'tmp_name',
		'type'	
	);
	
	public function handleRequest(FormCreator $form, $request = null){
		if(null !== $request){
			throw new \InvalidArgumentException('request must be null for NativeRequestHandler');
		}
		
		$name = $form->getName();
		$method = $form->getMethod();
		
		if('GET' === $method || 'HEAD' === $method || 'TRACE' === $method){
			if(null === $name){
				$data = $_GET;
			}else{
				if(!isset($_GET['name'])){
					return;
				}
				
				$data = $_GET[$name];
			}
		}else{
			$contentLength = $this->serverParams->getContentLength();
			$maxContentLength = $this->serverParams->getPostMaxSize();
			
			if(!empty($maxContentLength) && $contentLength > $maxContentLength){
				$form->submit(null, false);
				$form->addError('');
				
				return;
			}
			
			$fixedFiles = array();
			foreach($_FILES as $fileKey => $file){
				$fixedFiles[$fileKey] = self::stripEmptyFiles(self::fixPhpFilesArray($file));
			}
			
			if(null === $name){
				$params = $_POST;
				$files = $fixedFiles;
			}else if(array_key_exists($name, $_POST) || array_key_exists($key, $fixedFiles)){
				$default = array();
				$params = array_key_exists($name, $_POST) ? $_POST[$name] : $default;
				$files = array_key_exists($name, $fixedFiles) ? $fixedFiles[$name] : $default;
			}else{
				return;
			}
			
			if(is_array($params) && is_array($files)){
				$data = array_replace_recursive($params, $files);
			}else{
				$data = $params ?: $files;
			}
		}
		
		if(null === $name && count($data) <= 0){
			return;
		}
		
		$form->submit($data, 'PATCH' !== $method);
		
	}
	
	private static function getRequestMethod(){
		$method = isset($_SERVER['REQUEST_METHOD'])
			? strtoupper($_SERVER['REQUEST_METHOD'])
			: 'GET';
		
		if('POST' === $method && isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])){
			$method = strtoupper($_SERVER('HTTP_X_HTTP_METHOD_OVERRIDE'));
		}
		
		return $method;
	}
	
	private static function fixPhpFilesArray($data){
		if(!is_array($data)){
			return $data;
		}
		
		$keys = array_keys($data);
		sort($keys);
		
		if(self::$fileKeys !== $keys || !isset($data['name']) || !is_array($data['name'])){
			return $data;
		}
		
		$files = $data;
		foreach(self::$fileKeys as $k){
			unset($files[$k]);
		}
		
		foreach($data['name'] as $key => $name){
			$files[$key] = self::fixPhpFilesArray(array(
				'error' => $data['error'][$key],
				'name' => $name,
				'tmp_name' => $data['tmp_name'][$key],
				'size' => $data['size'][$key]
			));
		}
		
		return $files;
	}
	
	private static function stripEmptyFiles($data){
		if(!is_array($data)){
			return $data;
		}
		
		$keys = array_keys($data);
		sort($keys);
		
		if(self::$fileKeys === $keys){
			if(UPLOAD_ERR_NO_FILE === $data['error']){
				return;
			}
		}
		
		return $data;
	}
	
}