<?php

namespace Packimpex\ContentManager\Domain;

class Permission
{
	private static $valid_types = array('edit', 'delete', 'upload',
									 'update', 'view', 'rename');
									 
	/**
	 *@var Packimpex\ContentManager\Domain\User
	 */
	private $user = NULL;
	
	private $types = array();
	
	/**
	 *@var Packimpex\ContentManager\Domain\File
	 */
	private $content_item = NULL;
	
	public function __construct($user, array $types)
	{
		$this->user = $user;
		
		if (is_array($types)) {
			
			$unique_types = array_unique($types);
			
			foreach ($unique_types as $type) {
				if (in_array($type, self::$valid_types)) {
					array_push($this->types, $type);
				}
			}
		} 	
	}
	/*
	public function addPermission($other)
	{
		if (!$this->checkUser($other)) {
			return;
		}	
		$typeDiff = array_diff($other->types, $this->types); 
		array_merge($this->types, $typeDiff);	
	}
	*/
	public function setContentItem($file)
	{
		$this->content_item = $file;
	}
	
	public function getContentItem()
	{
		return $this->content_item;
	}
	
	public function getUser()
	{
		return $this->user;
	}
	
	public function setUser($user)
	{
		$this->user = $user;	
	}
	
	public function addType($type)
	{
		if (in_array($type, self::$valid_types) && !in_array($type, $this->types)) {
			array_push($this->types, $type);
		}
	}
	
	public function removeType($type)
	{
		$this->types = array_diff($this->types, array($type));
	}
	
	public function getTypes()
	{
		return $this->types;
	}
	/*
	public function removePermission($other)
	{
		if (!$this->checkUser($other)) {
			return;
		}	
		$typeDiff = array_diff($this->types, $other->types);
		$this->types = $typeDiff;
	}
	
	public function isEmpty()
	{
		return empty($this->types);
	}
	
	public function isEqual($other)
	{
		return ($this->$user->isEqual($other->$user) && 
				empty(array_diff($this->types, $other->types)) &&
				empty(array_diff($other->types, $this->types)));	
	}	
	
	private function checkUser($other) {
		return $other->getUser()->isEqual($this->user);
	}
	*/
}