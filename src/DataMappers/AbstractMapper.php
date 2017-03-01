<?php

namespace Packimpex\ContentManager\DataMappers;

abstract class AbstractMapper
{	
	/**
	 * @var Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 */
	protected $DB = null;
	
	protected $mapper_factory = null;

	protected $loadedMap = array();

	/**
	 * @param Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 * @param Packimpex\ContentManager\Configuration\MapperFactory $mapper_factory
	 */
	public function __construct($DBSingleton, $mapper_factory)
	{	
		$this->DB = $DBSingleton;
		$this->mapper_factory = $mapper_factory;
	}
	
	protected function abstractFind($id)
	{
		// checks if domain object is already cached
		if (isset($this->loadedMap[$id])) {
			return $this->loadedMap[$id];
		}
		
		$stmt = NULL;
		$result = NULL;
		
		try {
			$stmt = $this->DB->prepare($this->findStatement());
			$stmt->execute(array($id));
			return $this->load($stmt);
		} catch  (\PDOException $e) {
			echo "Database connection failed";
			exit;
		}	
	}
	
	abstract public  function find($id); 
	
	/*
	 * @return SQL statement string for key-based item selection 
	 */
	abstract protected function findStatement();
	
	/*
	 * @param $result Result of the SQL statemtn execution
	 * @return Domain object of interest 
	 */
	abstract protected function load($result);
	
	public function loadWhenCached($id, $result)
	{
		// checks if domain object is already cached
		if (isset($this->loadedMap[$id])) {
			return $this->loadedMap[$id];
		}
		$domain_object = $this->doLoad($id, $result);
		$this->loadedMap[$id] = $domain_object;
		return $domain_object;
	}
	
	abstract protected function doLoad($id, $result_row);
	
	abstract protected function loadFromArray($array);
	
}