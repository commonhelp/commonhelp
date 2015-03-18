<?php
namespace Commonhelp\Resource;

abstract class SubSystem extends AbstractResource{

	protected $session;
	
	public function __construct(Session $session){
		if(!$session instanceof Session && !is_resource($session)){
			throw new \InvalidArgumentException('Invalide session object');
		}
		
		$this->session = $session;
	}
	
	public function getSessionResource(){
		if ($this->session instanceof Session) {
			return $this->session->getResource();
		} else {
			return $this->session;
		}
	}
	
}

?>