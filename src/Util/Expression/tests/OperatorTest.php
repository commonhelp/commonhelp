<?php
namespace Commonhelp\Util\Expression;


use Commonhelp\Util\Expression\Context\BooleanGenericVisitor;
use Commonhelp\Util\Expression\Context\BooleanOperatorVisitor;
use Commonhelp\Util\Expression\Operator\SymbolExpression;
use Commonhelp\Util\Expression\Operator\LitteralExpression;

class OperatorTest extends \PHPUnit_Framework_TestCase{
	
	public function testBooleanOperatorExpression(){
		$visitor = new BooleanOperatorVisitor(false);
		$expression = new SymbolExpression(
				new LitteralExpression('x'),
				new LitteralExpression('2'),
				Operator\OperatorVisitor::LESSTHANEQUAL
		);
		
		
		$this->assertEquals('x  <=  2', $visitor->visit($expression));
	}
	
	public function testBooleanExpression(){
		$visitor = new BooleanGenericVisitor();
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
		$parsed = $visitor->visit($expression);
		$this->assertEquals('(( true  &&  false ) || ( true  && ( false  ||  true )))', $parsed);
		
	}
	
}