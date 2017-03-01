<?php

namespace Packimpex\ContentManager\DataMappers;

use Packimpex\ContentManager\Domain\Edition;
use Packimpex\ContentManager\Domain\Module;

class ModuleMapper extends AbstractMapper
{
	private $files_table = null; 
	private $files_module_id_field = null;
	private $file_id_field = null;
	private $editions_to_files_file_id_field = null;
	private $editions_to_files_table = null;
	private $edition_type_field = null;	

	private $transferees_user_id_field = null;
	private $modules_table = null;
	private $transferees_table = null;
	private $modules_trans_id_field = null;
	private $trans_id_field = null;
	private $module_id_field = null;

	/**
	 * @param Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 * @param Packimpex\ContentManager\Configuration\DatabaseTableMapper $database_tables_mapper
	 */
	public function __construct($DBSingleton, $database_tables_mapper, $mapper_factory)
	{
		parent::__construct($DBSingleton, $mapper_factory);


		$this->files_table = $database_tables_mapper->getFilesTable(); 
		$this->files_module_id_field = $database_tables_mapper->getFilesModuleIdField();
		$this->file_id_field = $database_tables_mapper->getFileIdField();
		$this->editions_to_files_file_id_field = $database_tables_mapper->getEditionsToFilesFileIdField();
		$this->editions_to_files_table = $database_tables_mapper->getEditionsToFilesTable();
		$this->edition_type_field = $database_tables_mapper->getEditionTypeField();

		$this->transferees_user_id_field = $database_tables_mapper->getTransfereesUserIdField();
		$this->modules_table = $database_tables_mapper->getModulesTable();
		$this->transferees_table = $database_tables_mapper->getTransfereesTable();
		$this->modules_trans_id_field = $database_tables_mapper->getModulesTransfereeIdField();
		$this->trans_id_field = $database_tables_mapper->getTransfereeIdField();
		$this->module_id_field = $database_tables_mapper->getModuleIdField();

	}
	
	public function findContentStatement()
	{
		return sprintf("SELECT * FROM %s WHERE %s = ? and %s NOT IN (SELECT %s FROM %s WHERE %s = 'delete')",
						$this->files_table, 
						$this->files_module_id_field,
						$this->file_id_field,
						$this->editions_to_files_file_id_field,
						$this->editions_to_files_table,
						$this->edition_type_field);
	}
	
	public function findTransfereeStatement()
	{
		return sprintf("SELECT t.%s FROM %s b, %s t WHERE b.%s = t.%s AND %s = ?",
						$this->transferees_user_id_field,
						$this->modules_table,
						$this->transferees_table,
						$this->modules_trans_id_field,
						$this->trans_id_field,
						$this->module_id_field);
	}
	
	public function find($id)
	{
		return $this->abstractFind($id);	
	}
	
	protected function load($result) 
	{
		$module = $result->fetch();
		return $this->doLoad($module[$this->module_id_field], $module);
	}
	
	protected function loadFromArray($module_array)
	{
		return $this->doLoad($module[$this->module_id_field], $module);
	}
	
	protected function doLoad($mod_key, $result_row)
	{
		$module = new Module($mod_key);
		$module->setContent($this->loadContent($mod_key));
		$module->setTransferee($this->loadTransferee($mod_key));
		return $module;
	}
	
	protected function loadContent($mod_key)
	{
		$stmt = null;
		$result = null;
		
		try {
			$result = array();
			$stmt = $this->DB->prepare($this->findContentStatement());
			$stmt->execute(array($mod_key));
			
			while ($file = $stmt->fetch()) {
				
				$content_object =$this->mapper_factory->contentMapper()->loadFromArray($file);
				array_push($result, $content_object);
			}
			
			return $result;
			
		} catch  (PDOException $e) {
			echo "Database connection failed";
			exit;
		}
	}
	
	protected function loadTransferee($mod_key)
	{
		$stmt = null;
		$result = null;
		
		try {
			$stmt = $this->DB->prepare($this->findTransfereeStatement());
			$stmt->execute(array($mod_key));
			$stmt_array = $stmt->fetch();
			
			$user_id = $stmt_array[$this->transferees_user_id_field];
			$transferee = $this->mapper_factory->userMapper()->find($user_id);
			return $transferee;
			
		} catch  (PDOException $e) {
			echo "Database connection failed";
			exit;
		}
	}
		
	protected function findStatement()
	{
		return sprintf("SELECT * FROM %s WHERE %s = ?", 
						$this->modules_table,
						$this->module_id_field);
	}
	
	/**
	 * @param Packimpex\ContentManager\Domain\File $file
	 * @param Packimpex\ContentManager\Domain\Module $module
	 * @param Packimpex\ContentManager\Domain\User $user
	 *
	 * @return void
	 */
	 public function delete($file, $user)
	 {	
		$this->mapper_factory->editMapper()->insert(new Edition($user, $file, 'delete', null));
	 }
}