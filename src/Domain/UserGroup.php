<?php

namespace Packimpex\ContentManager\Domain;

class UserGroup extends AbstractUser
{
	protected $is_group = TRUE;
	protected $users = array();
	private $group_name = NULL;
	
	public function __construct($group_id)
	{
		$this->user_id = $group_id;
	}
	
	public function setGroupName($new_group_name)
	{
		$this->group_name = $new_group_name;
	}
	
	public function getGroupName()
	{
		return $this->group_name;
	}
	
	public function equal($other)
	{
		return ($this->username == $other->username); 
	}
	
	public function overlapResolver($other)
	{
		$other->overlapsWithUserGroup($this);
	}
	
	public final function overlapsWithUser($other)
	{
		return ($this->getGroup() == $other->getGroup());
	}
	
	public final function overlapsWithUserGroup($other)
	{
		return $this->overlapWithUser($other);
	}
	
}