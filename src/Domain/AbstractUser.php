<?php

namespace Packimpex\ContentManager\Domain;

abstract class AbstractUser implements UserInterface
{	
	protected $user_id = NULL;
	
	public function isGroup() {
		return $this->is_group;
	}
	
	public function isEqual($other)
	{
		if ($this->getGroup() != $other->getGroup()) {
			return FALSE;
		}
		return $this->equal($other);
	}
	
	public function getUserId()
	{
		return $this->user_id;
	}
	
	public abstract function equal($other);
	
	public function overlapsWith($other) {
		$this->overlapResolver($other);
	}
	
	public abstract function overlapResolver($other);
	
	public abstract function overlapsWithUser($other);
	
	public abstract function overlapsWithUserGroup($other);
}