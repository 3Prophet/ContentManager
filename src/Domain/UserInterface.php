<?php

namespace Packimpex\ContentManager\Domain;

interface UserInterface
{
	public function isGroup();
	public function isEqual($other);	
	public function overlapsWith($other);
	public function overlapResolver($other);
	public function overlapsWithUser($other);
	public function overlapsWithUserGroup($other);
}