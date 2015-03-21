<?php
namespace Commonhelp\Util\Expression;

interface Expression{
	
	function interpret(Context $context);
	function stringfy(Context $context);
}

