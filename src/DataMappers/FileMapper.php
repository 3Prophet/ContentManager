<?php

namespace Packimpex\ContentManager\DataMappers;

use Packimpex\ContentManager\Domain\File;

class FileMapper extends AbstractMapper
{
	/**
	 * @var int file_id of the file last inserted into files table by a particular instance of this class
	 */
	private static $last_file_id = null;

	private $filename_field = null;
	private $file_id_field = null;
	private $files_table = null;
	private $files_module_id_field = null;
	private $files_job_id_field = null;
	private $upload_date_field = null;
	private $files_user_id_field = null;
	
	/**
	 * @var Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 * @var Packimpex\ContentManager\Configuration\DatabaseTableMapper $database_tables_mapper
	 */
	public function __construct($DBSingleton, $database_tables_mapper, $mapper_factory)
	{
		parent::__construct($DBSingleton, $mapper_factory);

		$this->filename_field = $database_tables_mapper->getFilenameField();
		$this->file_id_field = $database_tables_mapper->getFileIdField();
		$this->files_table = $database_tables_mapper->getFilesTable();
		$this->files_module_id_field = $database_tables_mapper->getFilesModuleIdField();
		$this->files_job_id_field = $database_tables_mapper->getFilesJobIdField();
		$this->upload_date_field = $database_tables_mapper->getUploadDateField();
		$this->files_user_id_field = $database_tables_mapper->getFilesUserIdField();
		
	}
	
	public function insertStatement()
	{
		// file_id must get autoincremented	
		return sprintf("INSERT INTO %s (%s, %s, %s, %s, %s) VALUES (?, ?, ?, ?, NOW())",
						$this->files_table,
						$this->filename_field,
						$this->files_module_id_field,
						$this->files_job_id_field,
						$this->files_user_id_field,
						$this->upload_date_field);
	}
											
													
	public function getLastItemId()
	{
		return $this->last_file_id;
	}
	
	/**
	 * 
	 * @param Packimpex\ContentManager\Domain\File $file
	 * @return void
	 */												
	public function insert($file)
	{
		/*
		if (!empty(array_diff(array("filename", "path", "bkg_id"), array_keys($values)))) {
			throw new \Exception("Missing fields!");
		}
		*/
		
		// TO-DO: transaction
		try {
			$stmt_insert = $this->DB->prepare($this->insertStatement());
			$stmt_insert->execute(array($file->getName(),
										$file->getModuleId(),
										$file->getJobId(),
										$file->getOwner()->getUserId()));
										
			$this->last_file_id = $this->DB->lastInsertId();
			$file->setId($this->last_file_id);

			/*
			$stmt_insert = self::$DB->prepare(self::$insert_statement);
			// inserting record into table files
			$stmt_insert->execute(array($values["path"], $values["filename"]));
			$file_id = self::$DB->lastInsertId();
			$this->last_file_id = $file_id;
			
			// inserting record into table uploads
			$stmt_upload = self::$DB->prepare(self::$upload_statement);
			$stmt_upload->execute(array($values["user_id"], $file_id));
			
			$stmt_content = self::$DB->prepare(self::$content_update_statement);
			$stmt_content->execute(array($values["bkg_id"], $file_id));
			
			*/
		} catch  (PDOException $e) {
			echo "Database connection failed";
			exit;
		}
		
	}
	
	public function find($file_id)
	{
		return $this->abstractFind($file_id);
	}
	/*												
	protected function findStatement()
	{
		return "SELECT * FROM files WHERE file_id=?";
	}*/
	
	public function findStatement()
	{
		return sprintf("SELECT * FROM %s WHERE %s = ?", $this->files_table,
														$this->file_id_field);
	}
	
	protected function load($result)
	{
		$file = $result->fetch();
		return $this->doLoad($file[$this->file_id_field], $file);
	}
	
	protected function doLoad($file_id, $file)
	{
		$fobj = new File($file[$this->filename_field],
						null,
						$file_id,
						$file[$this->files_job_id_field],
						$file[$this->files_module_id_field],
						null);
		
		// TO-DO: any further initializations if needed
		
		$fobj->setUserPermissions($this->loadUserPermissions($file_id));
		$fobj->setGroupPermissions($this->loadGroupPermissions($file_id));
		// TO-DO: perhaps editions are not needed to be loaded unless user might wanna see them
		//$fobj->setEditions($this->loadEditions($f_id));
				
		$fobj->setOwner($this->mapper_factory->userMapper()->find($file[$this->files_user_id_field]));
	
		return $fobj;
	}
	
	
	private final function loadGroupPermissions($file_id)
	{
		//$stmt = NULL;
		$result = NULL;
		
		$result =$this->mapper_factory->groupPermissionMapper()->findAll($file_id);
		
		/*
		try {
			$result = array();
			$stmt = self::$DB->prepare(self::$find_group_permissions_statement);
			$stmt->execute(array($file_id));
			
			while ($row =  MapperRegistry::groupPermissionMapper()->load($stmt)) {
				array_push($result, $row);
			}
			*/
		return $result;
		/*	
		} catch  (PDOException $e) {
			echo "Database connection failed";
			exit;
		}*/
	}
	
	private final function loadUserPermissions($file_id)
	{
		$stmt = NULL;
		$result = NULL;
		
		$result = $this->mapper_factory->userPermissionMapper()->findAll($file_id);
		return $result;
		/*
		try {
			$result = array();
			$stmt = self::$DB->prepare(self::$find_user_permissions_statement);
			$stmt->execute(array($file_id));
			
			// TO-DO: rewrite the code below to make single trip to the database(use loadAll)
			
			while ($row =  MapperRegistry::userPermisionMapper()->load($stmt)) {
				array_push($result, $row);
			}
			return $result;
			
		} catch  (PDOException $e) {
			echo "Database connection failed";
			exit;
		}*/
	}
	
	protected function loadFromArray($file_array)
	{
		return $this->find($file_array[$this->file_id_field]);
		//return $this->doLoad($file_array["file_id"], $file_array);
	}
	
}