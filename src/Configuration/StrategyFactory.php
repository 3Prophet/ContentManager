<?php

namespace Packimpex\ContentManager\Configuration;

class StrategyFactory
{
	/**
	 * @var array Maps strings to concrete Mapper classes 
	 */
	private $strategy_map = null;
	
	/**
	 * Singleton storage.
	 */									
	protected  $singleton_storage = array();
	
	private static $instance = null;
	
	private function __construct($strategy_map) {
		$this->strategy_map = $strategy_map;
	}
	
	public function getPermissionStrategy()
	{
		return $this->getFromSingletonMap("permission_strategy");
	}
	
	public function getDownloadStrategy()
	{
		return $this->getFromSingletonMap("download_strategy");
	}
	
	public function getUploadStrategy()
	{
		return $this->getFromSingletonMap("upload_strategy");
	}
	
	public function getDeleteStrategy()
	{
		return $this->getFromSingletonMap("delete_strategy");
	}
	
	public static function instance($strategy_map)
	{
		if (is_null(self::$instance)) {
			self::$instance = new self($strategy_map);
		}
		return self::$instance;
	}
	
	/**
	 * Helper method. Extracts a required Mapper from the Singleton Storage.
	 */
	protected function getFromSingletonMap($mapper_key)
	{
		if (isset($this->singleton_storage[$mapper_key])) {
			return $this->singleton_storage[$mapper_key];
		}

		$class =  $this->strategy_map[$mapper_key];
		$object = new $class();
		
		$this->singleton_storage[$mapper_key] = $object; 
		
		return $object;
	}
	
	public function getSingletonMap()
	{
		return $this->singleton_map;
	}
}
		
	