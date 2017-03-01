<?php

namespace Packimpex\ContentManager\DataMappers;

class EditMapper 
{
	private $editions_to_files_table = null;
	private	$editions_to_files_file_id_field = null;
	private	$editions_to_files_user_id_field = null;
	private	$edition_type_field = null;
	private	$edition_date_field = null;
										 									 
	protected $DB = null;
	protected $DB_tables_mapper = null;
	
	/**
	 * @param Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 * @param Packimpex\ContentManager\Configuration\DatabaseTableMapper $database_table_mapper
	 */
	public function __construct($DBSingleton, $database_table_mapper)
	{
		$this->DB = $DBSingleton;
		$this->DB_tables_mapper = $database_table_mapper;

		$this->editions_to_files_table = $database_table_mapper->getEditionsToFilesTable();
		$this->editions_to_files_file_id_field = $database_table_mapper->getEditionsToFilesFileIdField();
		$this->editions_to_files_user_id_field = $database_table_mapper->getEditionsToFilesUserIdField();
		$this->edition_type_field = $database_table_mapper->getEditionTypeField();
		$this->edition_date_field = $database_table_mapper->getEditionDateField();
	}		
	
	public function insertStatement()
	{
		return sprintf("INSERT INTO %s (%s, %s, %s, %s) VALUES (?, ?, ?, NOW())",
						$this->editions_to_files_table,
						$this->editions_to_files_file_id_field,
						$this->editions_to_files_user_id_field,
						$this->edition_type_field,
						$this->edition_date_field);
	}
										 
	/**
	 * Insert information about an update made to the file into the database
	 * 
	 * @param Packimpex\ContentManager\Domain\Edition $edition
	 * @return void
	 */									 
	public function insert($edition)
	{
		try {
			$stmt = $this->DB->prepare($this->insertStatement());
			$stmt->execute(array(
							$edition->getContentItem()->getId(),
							$edition->getUser()->getUserId(),
							$edition->getEditionType()
						));
		} catch  (\PDOException $e) {
			echo "Database connection failed";
			exit;
		}	
	}
}