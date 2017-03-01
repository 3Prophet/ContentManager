<?php

namespace Packimpex\ContentManager\DataMappers;

use Packimpex\ContentManager\Domain\Permission;

class UserPermissionMapper extends AbstractMapper
{									 
	private $permissions_users_user_id_field = null;
	private $permission_type_field = null;	
	private $permissions_users_table = null;
	private $permissions_users_file_id_field = null;	
									 
	/**
	 * @param Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 * @param Packimpex\ContentManager\Configuration\DatabaseTableMapper $database_tables_mapper
	 */
	public function __construct($DBSingleton, $database_tables_mapper, $mapper_factory)
	{
		parent::__construct($DBSingleton, $mapper_factory);
		
		$this->permissions_users_user_id_field = $database_tables_mapper->getPermissionsUsersUserIdField();
		$this->permission_type_field = $database_tables_mapper->getPermissionTypeField();
		$this->permissions_users_table = $database_tables_mapper->getPermissionsUsersTable();
		$this->permissions_users_file_id_field = $database_tables_mapper->getPermissionsUsersFileIdField();
		
	}
	/**
	 * @param Packimpex\ContentManager\Domain\Permission $permission
	 *
	 * @return void
	 */
	public function insert($permission)
	{
		try {
			$stmt = $this->DB->prepare($this->insertStatement());
			$stmt->execute(array(
							$permission->getContentItem()->getId(),
							$permission->getUser()->getUserId(),
							array_pop($permission->getTypes())));
		} catch  (\PDOException $e) {
			echo "Database connection failed";
			exit;
		}
	}
	
	public function insertStatement()
	{
		return sprintf("INSERT INTO %s (%s, %s, %s) VALUES (?, ?, ?)",
						$this->permissions_users_table,
						$this->permissions_users_file_id_field,
						$this->permissions_users_user_id_field,
						$this->permission_type_field);
	}
	
	
	protected function findStatement()
	{
		return sprintf("SELECT %s, %s FROM %s WHERE %s = ?",
						$this->permissions_users_user_id_field,
						$this->permission_type_field,
						$this->permissions_users_table,
						$this->permissions_users_file_id_field);
	}
	
	public function find($file_id)
	{
		return $this->findAll($file_id);
	}
	
	public function findAll($file_id)
	{
		try {
			$stmt = $this->DB->prepare($this->findStatement());
			$stmt->execute(array($file_id));
			$result = $this->loadAll($stmt);
			$stmt->closeCursor();
			return $result;
		} catch (PDOException $e) {
			echo "Database connection failed.";
			exit;
		}
	}
	
	protected function load($result)
	{		
		$permission = $result->fetch();
		return $this->doLoad($permission[$this->permissions_users_user_id_field], $permission);
	}
	
	protected function loadFromArray($permission_array)
	{
		return $this->doLoad($permission_array[$this->permissions_users_user_id_field], $permission_array);
	}
	
	protected function doLoad($user_id, $result_row)
	{
		$permission = new Permission($this->loadUser($user_id), 
									array($result_row[$this->permission_type_field]));
		//$permission->addType($result_row[$this->permission_type_field]);
		//$permission->setUser($this->loadUser($user_id));
		return $permission;
	}
	
	protected function loadAll($result)
	{
		// TO-DO: think about using identity map;
		$result_array = $result->fetchAll();
		// permission map where each permission is identified by group_id
		$permissions = array();
		
		foreach ($result_array as $result_row) {
			$user_id = $result_row[$this->permissions_users_user_id_field];
			if (isset($permissions[$user_id])) {
				$permissions[$user_id]->addType($result_row[$this->permission_type_field]);
			} else {
				$permissions[$user_id] = $this->doLoad($user_id, $result_row);	
			}
		}
		return array_values($permissions);
	}
	
	private final function loadUser($user_id)
	{
		return $this->mapper_factory->userMapper()->find($user_id);
	}
}