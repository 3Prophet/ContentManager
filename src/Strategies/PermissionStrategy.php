<?php

namespace Packimpex\ContentManager\Strategies;

use Packimpex\ContentManager\Domain\ManageableFile;
use Packimpex\ContentManager\Domain\UserWithPermissions;

/*
 * This stategy assumes the presense of a Default Permission Map.
 * This permission map sets permissions for user groups. 
 * Additional permissions are set if current user has
 * them.
 */
class PermissionStrategy
{	
	/*  
	 * @param \Packimpex\ContentManager\FileManager $file_manager	
	 * @return void
	 */
	public function apply($file_manager)
	{	
		//{group_id => array(permissions)}
		$permission_map = $file_manager->getGroupPermissionMap();
		$content = array();
		$module_content = $file_manager->getCurrentModule()->getContent();
		$current_user = $file_manager->getCurrentUser();
		$current_user_id = $current_user->getUserId();
		$current_user_group = $current_user->getUserGroup();
		$current_user_group_id = $current_user_group->getUserId();
		
		foreach ($module_content as $file) {
			$decorated_file = new ManageableFile($file);
			if (isset($permission_map[$current_user_group_id])) {
				$group_permission_types = $permission_map[$current_user_group_id];
				$this->setPermissionsOnFile($decorated_file, $file_manager,
											$group_permission_types);
			} 
			
			$user_permissions = $file->getUserPermissions();
						
			foreach ($user_permissions as $up) {
				if ($current_user_id == $up->getUser()->getUserId()) {
					$user_permission_types = $up->getTypes();
					$this->setPermissionsOnFile($decorated_file, $file_manager,
												$user_permission_types);
					break;
				}
			}
			array_push($content, $decorated_file);
		}
		$file_manager->setManagedContent($content);
		$this->setPermissionsOnUser($file_manager, $permission_map[$current_user_group_id]);
	}
	
	/* 
	 * @param \Packimpex\ContentManager\Domain\File $decorated_file
	 * @param \Packimpex\ContentManager\FileManager $file_manager
	 * @param array $permission_types Array of Strings(permissions)
	 */
	private function  setPermissionsOnFile($decorated_file, $file_manager, 
											array $permission_types)
	{
		foreach ($permission_types as $pt) {
			switch ($pt) {
				case "edit": 
					$decorated_file->setIsEditable(true);
					break;
				case "delete":
					$decorated_file->setIsRemovable(true);
					break;
				case "view":
					$decorated_file->setIsViewable(true);
					break;
			}
		}
		
	}
	
	private function setPermissionsOnUser($file_manager, array $permission_types)
	{
		foreach ($permission_types as $pt) {
			switch ($pt) {
				case "upload":
					$new_user = new UserWithPermissions(
										$file_manager->getCurrentUser());
					$new_user->setHasUploadRight(true);
					$file_manager->setCurrentUser($new_user);
					break;
			}
		}
	}
}
