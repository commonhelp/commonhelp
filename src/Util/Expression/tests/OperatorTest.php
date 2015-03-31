<?php
namespace Commonhelp\Util\Expression;

use Commonhelp\Util\Expression\Operator\SymbolExpression;
use Commonhelp\Util\Expression\Operator\LitteralExpression;
use Commonhelp\Util\Expression\Context\BooleanOperatorContext;
use Commonhelp\Util\Expression\Context\BooleanGenericContext;

class OperatorTest extends \PHPUnit_Framework_TestCase{
	
	public function testBooleanOperatorExpression(){
		$context = new BooleanOperatorContext();
		$expression = new SymbolExpression(
				new LitteralExpression('x'),
				new LitteralExpression('2')
		);
		
		$context->setSymbol('<=');
		
		$this->assertEquals('x <= 2', $expression->stringfy($context));
	}
	
	public function testBooleanExpression(){
		$context = new BooleanGenericContext();
		$three = new Boolean\ConstantExpression('true');
		$seven = new Boolean\ConstantExpression('false');
		$eighteen = new Boolean\ConstantExpression('true');
		$ten = new Boolean\ConstantExpression('false');
		$five = new Boolean\ConstantExpression('true');
		$expression = new Boolean\OrExpression(
			new Boolean\AndExpression($three, $seven),
			new Boolean\AndExpression(
				$eighteen,
				new Boolean\OrExpression(
					$ten,
					$five
				)	
			)
		);
		$parsed = $context->parse($expression);
		$this->assertEquals('(( true  &&  false ) || ( true  && ( false  ||  true )))', $parsed);
		
	}
	
}