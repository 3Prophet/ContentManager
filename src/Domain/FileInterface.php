<?php

namespace Packimpex\ContentManager\Domain;

interface FileInterface
{
	public function getName();
	public function setName($name); // string
	public function isFolder();
	public function setPath($path); // string 
	public function getPath();
	public function getFullName();
	public function setOwner($user); // class implementing User interface
	public function getOwner(); // returns class that implemens User interface
	public function setGroupPermissions(array $permissions);
	public function getGroupPermissions();
	public function setUserPermissions(array $permissions);
	public function getUserPermissions();
	//public function getPermissions();
	//public function addPermission($permission); // a member of Permission class
	//public function removePermission($permission);
	public function exists();
	public function isEqual($generic_file);
}