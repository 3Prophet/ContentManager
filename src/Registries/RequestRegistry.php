<?php

namespace Packimpex\ContentManager\Registries;

class RequestRegistry
{
	private static $instance = NULL;
	
	private $share_with_transferee = FALSE;
	private $filename = NULL;
	private $file_path = NULL; 
	private $edited_file_name = NULL;
	private $user_id = NULL;
	
	/**
	 * @var int An id that uniquely identifies job(say booking)
	 */
	 private $job_id = NULL;
	
	/**
	 * @var int Corresponds to say booking id
	 */
	private $module_item_id = NULL;
	
	/**
	 * @var int Corresponds to say file id
	 */
	private $content_item_id = NULL;
	
	/**
	 * @var array corresponds to $_FILES["fileToUpload_label"]
	 */
	private $file_to_upload = NULL;
	
	/**
	 * @var string Type of edition done to the content item
	 */
	private $types = NULL;
	
	private function __construct() {}
	
	public function instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function getUserId()
	{
		return $this->user_id;
	}
	
	public function setUserId($id)
	{
		$this->user_id = $id;
	}
	
	public function getModuleItemId()
	{
		return $this->module_item_id;
	}
	
	public function setModuleItemId($id)
	{
		$this->module_item_id = $id;
	}
	
	public function getFilePath()
	{
		return $this->file_path;
	}
	
	public function setFilePath($file_path)
	{
		$this->file_path = $file_path;
	}
	
	public function getFilename()
	{
		return $this->filename;
	}
	
	public function setFilename($filename)
	{
		$this->filename = $filename;
	}
	
	public function getTypes()
	{
		return $this->types;
	}
	
	/**
	 * Sets array of types of editions transferee would allow to do tho the content
	 */
	public function setTypes(array $types)
	{
		// TO-DO: set type validation code based on valid types
		$this->types = $types;
	}
	
	public function getShareWithTransferee()
	{
		return $this->share_with_transferee;
	}
	/**
	 * @param bool $share To share or not to share item with the transferee
	 * @return void
	 */
	public function setShareWithTransferee($share)
	{
		$this->share_with_transferee = $share;
	}
	
	/**
	 * @param array $file_to_upload corresponds to $_FILES["fileToUpload_label"] when file is uploaded
	 * @return void
	 */
	public function setFileToUploadArray(array $file_to_upload)
	{
		$this->file_to_upload = $file_to_upload;
	}
	
	public function getFileToUploadArray()
	{
		return $this->file_to_upload;
	}
	
	public function setContentItemId($id)
	{
		$this->content_item_id = $id;
	}
	
	public function getContentItemId()
	{
		return $this->content_item_id;
	}
	
	public function setJobId($id)
	{
		$this->job_id = $id;
	}
	
	public function getJobId()
	{
		return $this->job_id;
	}
}