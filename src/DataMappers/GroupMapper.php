<?php

namespace Packimpex\ContentManager\DataMappers;

use Packimpex\ContentManager\Domain\UserGroup;

class GroupMapper extends AbstractMapper
{	
	private $user_groups_table = NULL;
	private $user_group_id_field = NULL;
	private $user_group_field = NULL;
	
	/**
	 * @var Packimpex\ContentManager\Database\PDOSingleton $DBSingleton
	 * @var Packimpex\ContentManager\Configuration\DatabaseTableMapper $database_tables_mapper
	 */
	public function __construct($DBSingleton, $database_tables_mapper, $mapper_factory)
	{
		parent::__construct($DBSingleton, $mapper_factory);

		$this->user_groups_table = $database_tables_mapper->getUserGroupsTable();
		$this->user_group_id_field = $database_tables_mapper->getUserGroupIdField();
		$this->user_group_field = $database_tables_mapper->getUserGroupField();
	}
	
	public function find($id)
	{
		return $this->abstractFind($id);	
	}
	
	protected function findStatement()
	{
		return sprintf("SELECT * FROM %s WHERE %s = ?",
						$this->user_groups_table, 
						$this->user_group_id_field);
	}
	
	protected function load($result)
	{
		$group = $result->fetch();
		return $this->doLoad($group[$this->user_group_id_field], $group);
	}
	
	protected function loadFromArray($group_array)
	{
		return $this->doLoad($group[$this->user_group_id_field], $group_array);
	}
	
	protected function doLoad($group_id, $result_row)
	{
		$user_group = new UserGroup($group_id);
		$user_group->setGroupName($result_row[$this->user_group_field]);
		return $user_group;
	}
}