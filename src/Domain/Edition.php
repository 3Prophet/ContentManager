<?php 

namespace Packimpex\ContentManager\Domain;

class Edition
{
	/**
	 * @var Packimpex\ContentManager\Domain\User
	 */
	private $user = NULL;
	
	/**
	 * @var string
	 */	
	private $edition_type = NULL;
	
	/**
	 * @var string
	 */	
	private $date = NULL;
	
	
	/**
	 * @var Packimpex\ContentManager\Domain\File
	 */
	private $content_item = NULL;
	
	public function __construct($user, $file, $type, $date)
	{
		$this->user = $user;
		$this->content_item = $file;
		$this->edition_type = $type;
		$this->edition_date = $date;
	}
	
	public function getUser()
	{
		return $this->user;
	}
	
	public function getContentItem()
	{
		return $this->content_item;
	}
	
	public function getEditionType()
	{
		return $this->edition_type;
	}
}