<?php

namespace Packimpex\ContentManager\Configuration\IRS\Bookings;

class MapperMap
{	
	
	/**
	 * Maps strings to concrete Mapper class names.
	 */
	public static $mapper_map = array(
									"group_mapper" => "Packimpex\ContentManager\DataMappers\GroupMapper",
									"user_mapper" => "Packimpex\ContentManager\DataMappers\UserMapper",
									"user_permission_mapper" =>
											"Packimpex\ContentManager\DataMappers\UserPermissionMapper",
									"group_permission_mapper" => 
											"Packimpex\ContentManager\DataMappers\GroupPermissionMapper",
									"content_mapper" => "Packimpex\ContentManager\DataMappers\FileMapper",
									"module_mapper" => "Packimpex\ContentManager\DataMappers\ModuleMapper",
									"edit_mapper" => "Packimpex\ContentManager\DataMappers\EditMapper"
											);
}