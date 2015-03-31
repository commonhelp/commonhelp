<?php
namespace Commonhelp\Util\Expression;

interface Expression{
	
	function accept(Visitor $visitor);
}

