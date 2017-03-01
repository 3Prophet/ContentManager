<?php

namespace Packimpex\ContentManager\DataMappers;

use Packimpex\ContentManager\Domain\Permission;

class GroupPermissionMapper extends AbstractMapper
{
	private $permissions_groups_user_group_id_field = null;
	private $permissions_groups_permission_type_field = null;
	private $permissions_groups_table = null;
	private $permissions_groups_file_id_field = null;
		
	/**
	 * @param Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 * @param Packimpex\ContentManager\Configuration\DatabaseTableMapper $database_tables_mapper
	 */
	public function __construct($DBSingleton, $database_tables_mapper, $mapper_factory)
	{
		parent::__construct($DBSingleton, $mapper_factory);
		
		$this->permissions_groups_user_group_id_field = 
			$database_tables_mapper->getPermissionsGroupsUserGroupIdField();
		$this->permissions_groups_permission_type_field = 
			$database_tables_mapper->getPermissionsGroupsPermissionTypeField();
		$this->permissions_groups_table = 
			$database_tables_mapper->getPermissionsGroupsTable();
		$this->permissions_groups_file_id_field = 
			$database_tables_mapper->getPermissionsGroupsFileIdField();
	}
	
	protected function findStatement()
	{
		return sprintf("SELECT %s, %s FROM %s WHERE %s = ?",
						$this->permissions_groups_user_group_id_field,
						$this->permissions_groups_permission_type_field,
						$this->permissions_groups_table,
						$this->permissions_groups_file_id_field);
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
		return $this->doLoad(
			$permission[$this->permissions_groups_user_group_id_field],
			$permission);
	}
	
	protected function loadFromArray($permission_array)
	{
		return $this->doLoad(
			$permission_array[$this->permissions_groups_user_group_id_field],
			$permission_array);
	}
	
	protected function doLoad($group_id, $result_row)
	{
		$permission = new Permission(
							$this->loadGroup($group_id),
							array($result_row[$this->permissions_groups_permission_type_field]));
		//$permission->addType($result_row[$this->permissions_groups_permission_type_field]);
		//$permission->setUser($this->loadGroup($group_id));
		return $permission;
	}
	
	protected function loadAll($result)
	{
		// TO-DO: think about using identity map;
		$result_array = $result->fetchAll();
		// permission map where each permission is identified by group_id
		
		$permissions = array();
		
		foreach ($result_array as $result_row) {
			$group_id = $result_row[$this->permissions_groups_user_group_id_field];
			if (isset($permissions[$group_id])) {
				$permissions[$group_id]->addType(
					$result_row[$this->permissions_groups_permission_type_field]);
			} else {
				$permissions[$group_id] = $this->doLoad($group_id, $result_row);	
			}
		}
		return array_values($permissions);
	}
	
	private final function loadGroup($group_id)
	{
		return $this->mapper_factory->groupMapper()->find($group_id);
	}
}