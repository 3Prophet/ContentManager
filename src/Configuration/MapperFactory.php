<?php

namespace Packimpex\ContentManager\Configuration;

/**
 * A Factory of Singletons, which provides mappers for the FileManager application.
 */
class MapperFactory
{
	private static $instance = null;
	/**
	 * Maps strings to concrete Mapper class names.
	 */
	private $mapper_map = null;
	
	private $DB = null;
	
	private $database_table_mapper = null;
	
	/**
	 * Singleton storage.
	 */									
	protected $singleton_storage = array();
	
	protected function __construct($DB, $mapper_map, $database_table_mapper) {
		$this->DB = $DB;
		$this->mapper_map = $mapper_map;
		$this->database_table_mapper = $database_table_mapper;
	}
	
	public function groupMapper()
	{
		return $this->getFromSingletonMap("group_mapper");
	}
	
	public function userMapper()
	{
		return $this->getFromSingletonMap("user_mapper");
	}
	
	public function groupPermissionMapper()
	{
		return $this->getFromSingletonMap("group_permission_mapper");
	}
	
	public function userPermissionMapper()
	{
		return $this->getFromSingletonMap("user_permission_mapper");
	}
	
	public function contentMapper()
	{
		return $this->getFromSingletonMap("content_mapper");
	}
	
	public function moduleMapper()
	{
		return $this->getFromSingletonMap("module_mapper");
	}
	
	public function editMapper()
	{
		return $this->getFromSingletonMap("edit_mapper");
	}
	
	public static function instance($DB, $mapper_map, $database_table_mapper)
	{
		if (is_null(self::$instance)) {
			self::$instance = new self($DB, $mapper_map, $database_table_mapper);
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

		$class =  $this->mapper_map[$mapper_key];
		$object = new $class($this->DB, $this->database_table_mapper, $this);
		
		$this->singleton_storage[$mapper_key] = $object; 
		
		return $object;
	}
	public function getSingletonMap()
	{
		return $this->singleton_map;
	}
}