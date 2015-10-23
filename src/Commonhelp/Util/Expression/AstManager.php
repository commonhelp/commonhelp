<?php
namespace Commonhelp\Util\Expression;

interface AstManager{

	function getAst();
	
	function getVisitor();
	
	function __toString();
	
}