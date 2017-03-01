<?php

namespace Packimpex\ContentManager;

use Packimpex\ContentManager\Strategies\InitializationStrategy;

class FileManager
{
	/**
	 * @var int id number of the current user
	 */
	private $current_user_id = null;
	 
	/**
	 * @var \Packimpex\ContentManager\Domain\UserWithPermissions
	 */
	private $current_user = null;
	
	/*
	 * @var int id number of a module item
	 */
	private $module_item_id = null;
	
	/**
	 * @var \Packimpex\ContentManager\Domain\Module
	 */
	private $current_module = null;
	
	/**
	 * Should be delivered by the layer which uses FileManager to provide
	 * access to the layer's data, which is to be used to run FileManager.
	 * This is essentially the mean of communication between FileManager its client.
	 *
	 * @var \Packimpex\ContentManager\Registries\RequestRegistry
	 */
	 private $request_registry = null;
	
	/**
	 * @var array An array of \Packimpex\ContentManager\Domain\ManageableFile objects
	 */
	private $managed_content = array();
	
	private $mapper_factory = null;
	
	private $strategy_factory = null;
	
	private $module_mapper = null;
	
	// is needed to physically manage upload, delete etc.
	private $file_transfer_manager = null;
	
	/**
	 * File set for any kind of edition
	 * @var \Packimpex\ContentManager\Domain\ManageableFile 
	 */
	private $file_to_edit = null;
	
	/**
	 * @var array An array of default (user/group)permissions
	 */
	private $group_permission_map = null;
	/**
	 * @var Packimpex\ContentManager\Configuration\ConfigFactoryInterface $application_factory
	 */
	public function __construct($application_factory)
	{
		$this->group_permission_map = $application_factory->getGroupPermissionMap();
		$this->strategy_factory = $application_factory->getStrategyFactory();
		$this->request_registry = $application_factory->getRequestRegistry();
		
		//$this->mapper_map = $config->getMapperMap();
		$this->mapper_factory = $application_factory->getMapperFactory();
		
		$this->module_mapper = $this->mapper_factory->moduleMapper();
		$this->user_mapper = $this->mapper_factory->userMapper();
		

		// object that physically manages file manipulation
		$this->file_transfer_manager = $application_factory->getFileTransferManager();
		
		//$this->content_location = $config->getContentLocation();
		
	}
	
	/**
	 * Initialization the application. It looks into content of the Module and 
	 * compares 
	 */
	private function init()
	{
		// retrieving current user id
		$this->current_user_id = $this->request_registry->getUserId();

		// retrieving module item id
		$this->module_item_id = $this->request_registry->getModuleItemId();
		
		// temporarily assigned current user object
		$this->current_user = $this->user_mapper->find($this->current_user_id);

		// current module object
		$this->current_module = $this->module_mapper->find($this->module_item_id);
		
		// setting up initialization strategy
		//$this->strategy = $this->strategy_factory->getPermissionStrategy();
		
		// the strategy will substitute the instance of
		// \Packimpex\ContentManager\Domain\User in $this->current_user
		// with the instance of \Packimpex\ContentManager\Domain\UserWithPermissions
		$this->strategy_factory->getPermissionStrategy()->apply($this);

	}
	
	public function getManagedContent()
	{
		$this->init();
		return $this->managed_content;
	}
	
	public function setManagedContent(array $content)
	{
		$this->managed_content = $content;
	}
	
	public function getGroupPermissionMap()
	{
		return $this->group_permission_map;
	}
	
	public function getCurrentModule()
	{
		return $this->current_module;
	}
	
	public function getCurrentUser()
	{
		return $this->current_user;
	}
	
	public function setCurrentUser($user)
	{
		$this->current_user = $user;
		$this->current_user_id = $user->getUserId();
	}
	
	public function getCurrentUserId()
	{
		return $this->current_user_id;
	}
	
	public function getMapperFactory()
	{
		return $this->mapper_factory;
	}
	
	public function getModuleItemId()
	{
		return $this->module_item_id;
	}
	
	public function getJobId()
	{
		return $this->request_registry->getJobId();
	}
	
	public function handleUpload()
	{
		// Initialization and checking permissions
		$this->init();
		
		// file_array corresponds to $_FILES["fileToUpload_label"]
		$file_array = $this->request_registry->getFileToUploadArray();
		
		
		// TO-DO: move this responsibility away
		$this->file_transfer_manager->setDirname(basename($this->module_item_id));
		$this->file_transfer_manager->setFilename(basename($file_array["name"]));
		$this->file_transfer_manager->setFileToUploadArray($file_array);
		
		$this->strategy_factory->getUploadStrategy()->apply($this);
	}
	
	/**
	 * This function handles removal of a file from the current module 
	 */
	public function handleDelete()
	{	
		$this->init();	
		
		// setting file to be removed (for removal strategy)
		$this->file_to_edit = $this->getItemFromContent(
									$this->request_registry->getContentItemId());

								
		$module_item_id_parts = pathinfo($this->module_item_id);
		$filename_parts = pathinfo($this->file_to_edit->getName());
		
		// initializing file transfer manager	
			
		$this->file_transfer_manager->setDirname($module_item_id_parts["basename"]);
		$this->file_transfer_manager->setFilename($filename_parts["basename"]);
					
		$this->strategy_factory->getDeleteStrategy()->apply($this);
		
	}
	
	public function handleDownload()
	{
		$this->init();
		
		// setting file to be downloaded (for download strategy)
		$this->file_to_edit = $this->getItemFromContent(
									$this->request_registry->getContentItemId());
		
		$module_item_id_parts = pathinfo($this->module_item_id);
		$filename_parts = pathinfo($this->file_to_edit->getName());
		
		// initializing file transfer manager		
		$this->file_transfer_manager->setDirname($module_item_id_parts["basename"]);
		$this->file_transfer_manager->setFilename($filename_parts["basename"]);
		
		$this->strategy_factory->getDownloadStrategy()->apply($this);	
	}
	
	/**
	 * Return an item from the managed_content field
	 *
	 * @param int $id Key that identifies an item in the database
	 * @return \Packimpex\ContentManager\Domain\File
	 */
	public function getItemFromContent($id)
	{
		foreach ($this->managed_content as $item) {
			if ($item->getId() == $id) {
				return $item;
			}
		}
		throw new \Exception("FileNotFound!");
	}
	
	public function getFileTransferManager()
	{
		return $this->file_transfer_manager;
	}
	
	public function getContentLocation()
	{
		return $this->content_location;
	}
	
	public function getRequestRegistry()
	{
		return $this->request_registry;
	}
	
	public function getFileToEdit()
	{
		return $this->file_to_edit;
	}
	/*
	private function alreadyExists($filename) {
		if ($this->file_transfer_manager->fileExistsInDestination($filename)) {
			return TRUE;
		}
		return FALSE;
	}
	


	
	/* 
	 * Edits content of a file in the corrent booking.
	 */
	 /*
	public function handleEdit($file_id, $new_content)
	{
		if (!is_string($new_content)) {
			throw new Exception("Type error. Content type has to be string!");
		}
		
		$db_file = $this->getDBFile($file_id);
		$app_file = $this->getApplicationFile($db_file);
		
		if (!$app_file->isEditable()) {
			$bkg_id = $this->current_booking->getBkgId();
			throw new Exception(
			"You have no permission to edit file with id: $file_id for booking $bkg_id!");
		}
		// TO-DO: transaction-like edit
		$this->edit_mapper->insert($db_file, $this->current_user, "edit");
		$values = array("content" => $new_content);
		$this->file_mapper->update($db_file, $values);
						
	}
	
	public function handleUpdate($file_id)
	{
		$db_file = $this->getDBFile($file_id);
		$app_file = $this->getApplicationFile($db_file);
		
		if (!$upp_file->isUpdatable()) {
			throw new Exception(
			"You have no permission to update file with id: $file_id for booking $bkg_id!");
		}
		// TO-DO: transaction-like edit
		$this->edit_mapper->insert($db_file, $this->current_user, "update");
		$this->upload($db_file);
	}
	
	
	public function handleRename($file_id, $new_name)
	{
		if ($this->alreadyExists($new_name)) {
			throw new Exception(
				"File with this name already exists! Please choose another name.");
		}
		
		$db_file = $this->getDBFile($file_id);
		$app_file = $this->getApplicationFile($db_file);
		
		if (!$upp_file->isRenameable()) {
			throw new Exception(
			"You have no permission to rename file with id: $file_id for booking $bkg_id!");
		}
		//TO-DO: Transaction for file-renaming
		$this->edit_mapper->insert($db_file, $this->current_user, "rename");
		$this->file_mapper->update($db_file, array("filename" => $new_name));
	}
	

	
	
	/*
	 *                             --------------INITIALIZATION------------------
	 * 1.Initialize current user;
	 * 2.Initialize current booking;
	 * 3.Check database for:
	 	a. the documents(content in general) available for the current booking
	    b. check permissions/ownership of the content and build list of documents which can be displayed and edited 	  
	 * 4.Compare the list of those documents with the documents available in the folder of the corresponding booking.
	 	a.If the document from the folder is in the prohibited list - don't display.
		b.If it is not in the database but in folder than it has no owner, mark is a owner free(uploadable) and display
		c.If it is in the allowed list but not in the folder issue notification, delete the document and its related info from the database
			and do not display
			
								-------------------UPLOAD MANAGEMENT----------------
								
		1. Perform initialization
		2. For the uploaded file initialize the File class, set owner and save it to the database		
		
								-------------------REMOVAL MANAGEMENT--------------------
		1. Perform initialization
		2. For the removed file: check the ownership and remove permissions and database entries and mark as uploadable.				
								
								
								-------------------GIVING PERMISSIONS---------------
		1. Perform initialization
		2. For the file check the ownership, Initialize and update Permission, update the database.
			
		 
	 */
	
	
	
	
	
	
}