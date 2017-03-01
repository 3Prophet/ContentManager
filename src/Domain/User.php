<?php

namespace Packimpex\ContentManager\Domain;

class User extends AbstractUser
{
	private $username = NULL;
	private $fullName = NULL;
	protected $is_group = FALSE;
	private $user_group = NULL;
	
	public function __construct($user_id)
	{
		$this->user_id = $user_id;
	}
	
	public final function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername($new_username)
	{
		$this->username = $new_username;	
	}
	
	public function setUserGroup($new_user_group)
	{
		$this->user_group = $new_user_group;
	}
	
	public function getUserGroup()
	{
		return $this->user_group;
	}
	
	public function getFullName()
	{
		return $this->fullName;
	}
	
	public function equal($other)
	{
		return ($this->username == $other->username); 
	}
	
	public function overlapResolver($other)
	{
		$other->overlaspWithUser($this);
	}
		
	public final function overlapsWithUser($other)
	 {
		return ($this->getUsername() == $other->getUsername());
	}
	
	public final function overlapsWithUserGroup($other)
	{
		return ($this->getGroup() == $other->getGroup());
	}
}