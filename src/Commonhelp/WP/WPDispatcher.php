<?php
namespace Commonhelp\WP;

use Commonhelp\App\Dispatcher;
use Commonhelp\WP\WPController;
use Commonhelp\App\Exception\TemplateNotFoundException;
use Commonhelp\WP\WPTemplate;
use Commonhelp\App\Http\JsonResponse;
use Commonhelp\WP\Exception\WPResponderNotFoundException;

class WPDispatcher extends Dispatcher{
	
	protected function executeController(WPController $controller, $methodName) {
		$controller->setAction($methodName);
		$arguments = $this->request->getUrlParams();
		$response = call_user_func_array(array($controller, $methodName), $arguments);
		if(is_null($response)) {
			if($this->reflector->getResponder() === null){
				$response = $controller->render($response, 'template');
			}else{
				$responder = $this->reflector->getResponder();
				if($controller->hasResponder($responder)){
					$response = $controller->render($response, $responder);
				}else{
					throw new WPResponderNotFoundException('Responder: '.$responder.' not register for '
							.get_class($controller));
				}
			}
		}else if(is_array($response)){
			$response = new JsonResponse($response);
		}else{
			$data = array('data' => $response);
			$response = new JsonResponse($data);
		}
		return $response;
	}
}