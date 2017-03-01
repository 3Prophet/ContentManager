<?php

namespace Packimpex\ContentManager\DataMappers;

use Packimpex\ContentManager\Domain\User;

class UserMapper extends AbstractMapper
{
	private $users_table = null;
	private $user_id_field = null;
	private $users_user_group_id_field = null;
	private $user_name_field = null;
	
	/**
	 * @param Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 * @param Packimpex\ContentManager\Configuration\DatabaseTableMapper $database_tables_mapper
	 */
	public function __construct($DBSingleton, $database_tables_mapper, $mapper_factory)
	{
		parent::__construct($DBSingleton, $mapper_factory);

		$this->users_table = $database_tables_mapper->getUsersTable();
		$this->users_user_group_id_field = $database_tables_mapper->getUsersUserGroupIdField();
		$this->user_id_field = $database_tables_mapper->getUserIdField();
		$this->username_field = $database_tables_mapper->getUsernameField();
	}
	
	public function findUserGroupStatement()
	{
		return sprintf("SELECT %s FROM %s WHERE %s = ?",
						$this->users_user_group_id_field,
						$this->users_table,
						$this->user_id_field);
	}
												
	public function find($user_id)
	{
		return $this->abstractFind($user_id);
	}
													
	protected function findStatement()
	{
		return sprintf("SELECT * FROM %s WHERE %s = ?",
						$this->users_table,
						$this->user_id_field);
	}
	
	protected function load($result)
	{
		$user = $result->fetch();
		return $this->doLoad($user[$this->user_id_field], $user);
	}
	
	protected function loadFromArray($user_array)
	{
		return $this->doLoad($user[$this->user_id_field], $user_array);
	}
	
	protected function doLoad($user_id, $result_row)
	{
		$user = new User($user_id);
		$user->setUsername($result_row[$this->username_field]);
		$user->setUserGroup($this->loadUserGroup($user_id));
		return $user;
	}
	
	private final function loadUserGroup($user_id)
	{
		$stmt = null;
		$result = null;
		
		try {
			$stmt = $this->DB->prepare($this->findUserGroupStatement());
			$stmt->execute(array($user_id));
			$result = $stmt->fetch();
			$user_group_id = $result[$this->users_user_group_id_field];			
			return  $this->mapper_factory->groupMapper()->find($user_group_id);
		} catch  (PDOException $e) {
			echo "Database connection failed";
			exit;
		}
	}
}