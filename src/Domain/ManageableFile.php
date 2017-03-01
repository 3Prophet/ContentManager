<?php

namespace Packimpex\ContentManager\Domain;

class ManageableFile implements FileInterface, ManageableFileInterface
{
	private $is_viewable = FALSE;
	private $is_editable = FALSE;
	private $is_removable = FALSE;
	private $is_deletable = FALSE;
	private $is_visible = FALSE;
	
	private $decorated_file = NULL;
	
	public function __construct($file_to_decorate)
	{
		$this->decorated_file = $file_to_decorate;	
	}
	//TO-DO: add method to an interface?
	public function getId()
	{
		return $this->decorated_file->getId();
	}
	
	public function getDecoratedFile()
	{
		return $this->decorated_file;
	}
	
	public function setIsEditable($value)
	{
		if (is_bool($value)) {
			$this->is_editable = $value;
		}
	}
	
	public function getIsEditable()
	{
		return $this->is_editable;
	}
	
	public function setIsRemovable($value)
	{
		if (is_bool($value)) {
			$this->is_removable = $value;
		}
	}
	
	public function getIsRemovable()
	{
		return $this->is_removable;
	}
	
	public function setIsVisible($value)
	{
		if (is_bool($value)) {
			$this->is_visible = $value;
		}
	}
	
	public function getIsVisible()
	{
		return $this->is_visible;
	}
	
	public function setIsViewable($value)
	{
		if (is_bool($value)) {
			$this->is_viewable = $value;
		}
	}
	
	public function getIsViewable()
	{
		return $this->is_viewable;
	}
	
	public function getName()
	{
		return $this->decorated_file->getName();
	}
	
	public function setName($name)
	{
		$this->decorated_file->setName($name);
	}
	
	public function isFolder()
	{
		return $this->decorated_file->isFolder();
	}
	
	public function setPath($path)
	{
		$this->decorated_file->setPath($path);
	}
	
	public function getPath()
	{
		return $this->decorated_file->getPath();
	}
	
	public function getFullName()
	{
		return $this->decorated_file->getFullName();
	}
	
	public function setOwner($user)
	{
		$this->decorated_file->setOwner($user);
	}
	
	public function getOwner()
	{
		return $this->decorated_file->getOwner();
	}
	/*
	public function getPermissions()
	{
		return $this->decorated_file->getPermissions();
	}
	
	public function addPermission($permission)
	{
		$this->decorated_file->addPermission($permission);
	}
	
	public function removePermission($permission)
	{
		$this->decorated_file->remove_permission($permission);
	}
	*/
	public function exists()
	{
		return $this->decorated_file->exists();
	}
	
	public function isEqual($genericFile)
	{
		return $this->decorated_file->isEqual($genericFile);
	}	
	
	public function getGroupPermissions()
	{
		return $this->decorated_file->getGroupPermissions();
	}
	
	public function setGroupPermissions(array $group_permissions)
	{
		$this->decorated_file->setGroupPermissions($group_permissions);
	}
	
	public function getUserPermissions()
	{
		return $this->decorated_file->getUserPermissions();
	}
	
	public function setUserPermissions(array $user_permissions)
	{
		$this->decorated_file->setUserPermissions($group_permissions);
	}
}