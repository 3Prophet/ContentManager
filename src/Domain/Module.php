<?php

namespace Packimpex\ContentManager\Domain;

class Module
{
	private $module_item_id = NULL;
	private $content = NULL;
	private $transferee = NULL;
	
	/**
	 * @var \Packimpex\ContentManager\Domain\File
	 */
	private $file_to_edit = NULL;
	
	/**
	 * @var \Packimpex\ContentManager\Domain\User
	 */
	private $user = NULL;
	
	public function __construct($item_id)
	{
		$this->module_item_id = $item_id;
	}
	
	public function setContent(array $content)
	{
		$this->content = $content;
	}
	
	public function getContent()
	{
		return $this->content;
	}
	
	/**
	 * @param Packimpex\ContentManager\Domain\User $transferee
	 */
	public function setTransferee($transferee)
	{
		$this->transferee = $transferee;
	}
	
	public function getTransferee()
	{
		return $this->transferee;
	}
	
	public function setUser($user)
	{
		$this->user = $user;
	}
	
	public function getUser($user)
	{
		return $this->user;
	}
	
	public function setFileToEdit($file)
	{
		$this->file_to_edit = $file;
	}
	
	public function getFileToEdit()
	{
		return $this->file_to_edit;
	}
	
	public function getModuleItemId()
	{
		return $this->module_item_id;
	}
}