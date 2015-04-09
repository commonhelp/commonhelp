<?php

namespace Commonhelp\Orm;
use Commonhelp\Orm\Exception\DataLayerException;

use PDO;

class PdoDataLayer extends DataLayerInterface{
	
	protected $pdo;
	protected $adaptee;
	
	public function __construct(array $options){
		if(!isset($options['dsn'])){
			throw new DataLayerException('DSN string must be provided to a database connection');
		}
		if(!isset($options['username'])){
			$options['username'] = '';
		}
		if(!isset($options['password'])){
			$options['password'] = '';
		}
		$this->pdo = new PDO($options['dsn'], $options['username'], $options['password']);
		
		/**
		 * MUST USE FULL NAMESPACE
		 *@see http://stackoverflow.com/questions/18337650/how-to-check-the-existence-of-a-namespace-in-php
		 */
		$adaptee = "Commonhelp\\Orm\\".ucfirst($this->getDriver().'DataAdaptee');
		$visitor = "Commonhelp\\Orm\\Sql\\".ucfirst($this->getDriver().'Visitor');
		$this->adaptee = new $adaptee();
		$this->visitor = new $visitor($this);
	}
	
	public static function instance(array $options){
		if(!static::$instance){
			static::$instance = new PdoDataLayer($options);
		}
		
		return static::$instance;
	}
	
	public static function getAvailableDriver(){
		return PDO::getAvailableDrivers();
	}
	
	public function quote($string){
		return $this->pdo->quote($string);
	}
	
	public function quoteColumnName($string){
		
	}
	
	public function quoteTableName($strin){
		
	}
	
	protected function getDriver(){
		return $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
	}
	
}
