<?php
namespace Commonhelp\Form\RequestHandler;

use Commonhelp\Form\FormCreator;

interface RequestHandlerInterface{
	
	/**
	 * Submits a form if it was submitted.
	 *
	 * @param FormCreator $form    The form to submit.
	 * @param mixed         $request The current request.
	 */
	public function handleRequest(FormCreator $form, $request = null);
	
}