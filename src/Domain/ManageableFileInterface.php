<?php

namespace Packimpex\ContentManager\Domain;

interface ManageableFileInterface extends FileInterface
{
	public function setIsEditable($value);
	public function getIsEditable();
	public function setIsRemovable($value);
	public function getIsRemovable();
	public function setIsVisible($value);
	public function getIsVisible();
	public function setIsViewable($value);
	public function getIsViewable();
	public function getDecoratedFile();	
}