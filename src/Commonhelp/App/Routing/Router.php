<?php
namespace Commonhelp\App\Routing;

use Commonhelp\Config\Configurator\Parser\ParserInterface;
use Symfony\Component\Routing\RequestContext;
use Psr\Log\LoggerInterface;
use Commonhelp\App\Http\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Router{
	
	private $parser;
	private $resource;
	private $context;
	private $logger;
	
	private $matcher;
	private $generator;
	
	private $collection;
	
	private $options;
	
	public function __construct(ParserInterface $parser, $resource, $context = '', LoggerInterface $logger = null){
		$this->parser = $parser;
		$this->resource = $resource;
		$this->context = new RequestContext($context);
		$this->options = array(
				'generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
				'generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
				'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper',
				'generator_cache_class' => 'ProjectUrlGenerator',
				'matcher_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
				'matcher_base_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
		);
	}
	
	public function generate($name, $parameters=array(), $referenceType=UrlGeneratorInterface::ABSOLUTE_PATH){
		return $this->getGenerator()->generate($name, $parameters, $referenceType);
	}
	
	public function getRouteCollection(){
		if(null === $this->collection){
			
		}
		
		return $this->collection;
	}
	
	public function getGenerator(){
		if(null !== $this->generator){
			return $this->generator;
		}
		return 
			$this->generator = new $this->options['generator_class'](
					$this->getRouteCollection(), $this->context, $this->logger);
	}
	
	
	
	public function match($pathinfo){
		return $this->getMatcher()->match($pathinfo);
	}
	
	public function matchRequest(Request $request){
		$matcher = $this->getMatcher();
		return $matcher->match($request->getPathInfo());
	}
	
	public function getMatcher(){
		return $this->matcher = new $this->options['matcher_class'];
	}
	
}