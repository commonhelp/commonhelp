<?php
namespace Commonhelp\Asset\Context;

use Commonhelp\App\Http\RequestInterface;
use Commonhelp\App\Http\Request;

class RequestContext implements ContextInterface{
	
	private $request;
	
	public function __construct(Request $request){
		$this->request = $request;
	}
	
	public function getBasePath(){
		return $this->request->getBasePath();
	}
	
	public function isSecure(){
		return $this->request->isSecure();
	}
	
}