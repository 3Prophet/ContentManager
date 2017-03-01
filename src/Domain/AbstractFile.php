<?php

namespace Packimpex\ContentManager\Domain;

abstract class AbstractFile implements FileInterface
{
	protected $name = NULL;
	protected $owner = NULL; // instance of User class
	protected $path = NULL;
	protected $user_permissions = NULL;
	protected $group_pemissions = NULL;
	protected $job_id = NULL; // say id that differentiates booking from transfer jobs
	protected $module_id = NULL; // say booking id
	
	public function  getJobId()
	{
		return $this->job_id;
	}
	
	public function getModuleId()
	{
		return $this->module_id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getId()
	{
		return $this->file_id;
	}
	
	public function setId($id)
	{
		$this->file_id = $id;
	}
	
	public function setName($name) // string
	{
		$this->name = $name;
	}
	
	public function isFolder()
	{
		return $this->is_folder;
	}
	
	public function setPath($path)
	{
		if (file_exists($path) && is_dir($path)) {
			$this->path = split(DIRECTORY_SEPARATOR, trim($path));
		}
	}
	
	public function getPath()
	{
		if ($this->part != NULL) {
			return join(DIRECTORY_SEPARATOR, $this->path);
		}
		return $this->part;
	}
	
	public final function getFullName()
	{
		if ($this->path != NULL && $this->name != NULL) {
			return join(DIRECTORY_SEPARATOR,
						 array_push($this->path, $this->name));
		}
	}
	
	public function setOwner($user) // class implementing User interface
	{
		$this->owner = $user;
	}
	
	public function getOwner()
	{
		return $this->owner;
	}
	
	/*
	 * Returns a deep copy of the permissions array
	*/ 
	/*
	public function getPermissions()
	{
		if ($this->permissions != NULL) {
			$permissionArray = array();
			foreach ($this->permissions as $permission) {
				$permissinDeepCopy = clone($permission);
				array_push($permissionArray, $permissionDeepCopy);
			}
			return $permissionArray;
		}
		return $this->permissions;	
	}
	*/
	
	public function setGroupPermissions(array $permission_array)
	{
		$this->group_permissions = $permission_array;
	}
	
	public function getGroupPermissions()
	{
		return $this->group_permissions;
	}
	
	public function setUserPermissions(array $permission_array)
	{
		$this->user_permissions = $permission_array;
	}
	
	public function getUserPermissions()
	{
		return $this->user_permissions;
	}
	
	 
	/*
	public function addPermission($newPermission)
	{
		if ($this->permissions = !NULL) {
			$alreadyAdded = FALSE;
			foreach ($this->permissions as $permission) {	
				if ($permission->isEqual($newPermission)) {
					$permission->addPermission($newPermission);
					$alreadyAdded = TRUE;
					break;
				}
			}
			if (!$alreadyAdded) {
				array_push($this->permissions, $newPermission);
			}
		} else {
			$this->permissions = array();
			array_push($permission);
		}
	}
	
	public function removePermission($remPermission)
	{
		if ($this->permissions != NULL) {	
			foreach ($this->permissions as $permission) {
				if ($permission->isEqual($remPermission)) {
					$permission->subtractPermission($remPermission);
					return $permission;
				}
			}
		} else {
			return NULL;
		}
	}
	*/
	
	public function exists()
	{
		return file_exists($this->getFullName());
	}
	
	public final function isEqual($genericFile)
	{
		$thisClass = get_class($this);
		$otherClass = get_class($genericFile);
		
		if (!($thisClass == $otherClass)) {
			return FALSE;
		}		
		return ($this->getFullName() == $genericFile->getFullName());
	}
	
}