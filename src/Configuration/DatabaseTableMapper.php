<?php

namespace Packimpex\ContentManager\Configuration;

/**
 * Stores mapping of prototype database tables and fields to those
 * used in the application 
 */
class DatabaseTableMapper
{	
	/**
	 * An array wchich maps prototype database tables and fields to those 
	 * used in the application. The scheme for the prototype database is 
	 * stored in the documentation folder. 
	 *
	 * @var array 
	 */								
	private $table_map = null;																	
																					
	public function __construct($table_map)
	{
		$this->table_map = $table_map;
	}

	public function getTableMap()
	{
		return $this->table_map;
	}
	

	public function getFromTableMap($key)
	{
		if(isset($this->table_map[$key])) {
			return $this->table_map[$key];
		} else {
			
			$message = sprintf("The key '$key' does not exist in the 'table_map' field of class %s!", 
								__CLASS__);
			throw new \Exception($message);
			
		} 
	}

	/**
	 * Returns name of the table that service the same purpose as 
	 * "user_groups" prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getUserGroupsTable()
	{
		return $this->getFromTableMap("user_groups");
	}

	public function getUserGroupIdField()
	{
		return $this->getFromTableMap("user_group_id");
	}

	public function getUserGroupField()
	{
		return $this->getFromTablemap("user_group");
	}

	/**
	 * Returns name of the table that service the same purpose as "users"
	 * prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getUsersTable()
	{
		return $this->getFromTableMap("users");
	}

	public function getUserIdField()
	{
		return $this->getFromTableMap("user_id");
	}

	public function getUsernameField()
	{
		return $this->getFromTableMap("username");
	}	

	public function getUsersUserGroupIdField()
	{
		return $this->getFromTableMap("users_user_group_id");
	}

	/**
	 * Returns name of the table that service the same purpose as "transferees"
	 * prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getTransfereesTable()
	{
		return $this->getFromTableMap("transferees");
	}

	public function getTransfereeIdField()
	{
		return $this->getFromTableMap("trans_id");
	}

	public function getTransfereesUserIdField()
	{
		return $this->getFromTableMap("transferees_user_id");
	}

	/**
	 * Returns name of the table that service the same purpose as
	 * "permissions_users" prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getPermissionsUsersTable()
	{
		return $this->getFromTableMap("permissions_users");
	}

	public function getPermissionsUsersFileIdField()
	{
		return $this->getFromTableMap("permissions_users_file_id");
	}

	public function getPermissionsUsersUserIdField()
	{
		return $this->getFromTableMap("permissions_users_user_id");
	}

	public function getPermissionTypeField()
	{
		return $this->getFromTableMap("permission_type");
	}	

	/**
	 * Returns name of the table that service the same purpose as
	 * "permissions_groups" prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getPermissionsGroupsTable()
	{
		return $this->getFromTableMap("permissions_groups");
	}	

	public function getPermissionsGroupsFileIdField()
	{
		return $this->getFromTableMap("permissions_groups_file_id");
	}

	public function getPermissionsGroupsUserGroupIdField()
	{
		return $this->getFromTableMap("permissions_groups_user_group_id");
	}

	public function getPermissionsGroupsPermissionTypeField()
	{
		return $this->getFromTableMap("permissions_groups_permission_type");
	}

	/**
	 * Returns name of the table that service the same purpose as 
	 * "files" prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getFilesTable()
	{
		return $this->getFromTableMap("files");
	}									
	
	public function getFileIdField()
	{
		return $this->getFromTableMap("file_id");
	}	
	
	public function getFilenameField()
	{
		return $this->getFromTableMap("filename");
	}

	public function getUploadDateField()
	{
		return $this->getFromTableMap("upload_date");
	}		
	
	public function getFilesUserIdField()
	{
		return $this->getFromTableMap("files_user_id");
	}

	public function getFilesModuleIdField()
	{
		return $this->getFromTableMap("files_module_id");
	}

	public function getFilesJobIdField()
	{
		return $this->getFromTableMap("files_job_id");
	}

	/**
	 * Returns name of the table that service the same purpose as "jobs"
	 * prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getJobsTable()
	{
		return $this->getFromTableMap("jobs");
	}

	public function getJobIdField()
	{
		return $this->getFromTableMap("job_id");
	}

	/**
	 * Returns name of the table that service the same purpose as "modules"
	 * prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getModulesTable()
	{
		return $this->getFromTableMap("modules");
	}

	public function getModuleIdField()
	{
		return $this->getFromTableMap("module_id");
	}

	public function getModulesTransfereeIdField()
	{
		return $this->getFromTableMap("modules_transferee_id");
	}

	/**
	 * Returns name of the table that service the same purpose as
	 * "editions_to_files" prototype table.
	 *
	 * @param void
	 *
	 * @return string 
	 */
	public function getEditionsToFilesTable()
	{
		return $this->getFromTableMap("editions_to_files");
	}

	public function getEditionsToFilesFileIdField()
	{
		return $this->getFromTableMap("editions_to_files_file_id");
	}

	public function getEditionsToFilesUserIdField()
	{
		return $this->getFromTableMap("editions_to_files_user_id");
	}

	public function getEditionDateField()
	{
		return $this->getFromTableMap("edition_date");
	}

	public function getEditionTypeField()
	{
		return $this->getFromTableMap("edition_type");
	}
}