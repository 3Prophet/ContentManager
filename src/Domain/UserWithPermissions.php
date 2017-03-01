<?php

namespace Packimpex\ContentManager\Domain;

class UserWithPermissions
{
	/*
	 * @var Packimpex\ContentManager\Domain\User A decorated user
	 */
	private $decorated_user = NULL;
	
	private $has_upload_right = FALSE;
	
	public function __construct($decorated_user)
	{
		$this->decorated_user = $decorated_user;
	}
	
	public function getDecoratedUser()
	{
		return $this->decorated_user;
	}
	
	public function getHasUploadRight()
	{
		return $this->has_upload_right;
	}
	
	public function setHasUploadRight($value)
	{
		if (is_bool($value)) {
			$this->has_upload_right = $value;
		} 
	}
	
	public function getUserId()
	{
		return $this->decorated_user->getUserId();
	}
}