<?php

namespace Packimpex\ContentManager\Configuration\IRS;

class DatabaseTableMap
{	
									// DONE!
	public static $database_table_map = array("user_groups" => "user_groups", 
									"user_group_id" => "user_group_id",
									"user_group" => "user_group",
									
									// DONE!				  
									"users" => "users",
									"user_id" => "user_id",
									"username" => "username",
									"users_user_group_id" => "user_group_id",

									"transferees" => "transferees",
									"trans_id" => "trans_id",
									"transferees_user_id" => "user_id",
									
									// DONE!				
									"permissions_users" => "permissions_users",
									"permission_type" => "type",
									"permissions_users_file_id" => "file_id",
									"permissions_users_user_id" => "user_id",

									// DONE !
									"permissions_groups" => "permissions_groups",
									"permissions_groups_file_id" => "file_id",
									"permissions_groups_user_group_id" => "user_group_id",
									"permissions_groups_permission_type" => "type",
													
									"files" => "files",
									"filename" => "filename",
									"file_id" => "file_id",
									"upload_date" => "upload_date",
									"files_user_id" => "uploader_id",
									"files_module_id" => "module_id",
									"files_job_id" => "job_id",
													
									"modules" => "bookings",
									"module_id" =>"bkg_id",
									"modules_transferee_id" => "trans_id",
									
									// job_title should correspond to "modules" value 				
									"jobs" => "jobs",
									"job_id" => "job_id",
									
									"editions_to_files" => "editions_to_files",
									"edition_date" => "edition_date",
									"edition_type" => "edition_type",
									"editions_to_files_file_id" => "file_id",
									"editions_to_files_user_id" => "user_id"
										
									);
}