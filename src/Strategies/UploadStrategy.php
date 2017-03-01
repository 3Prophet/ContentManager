<?php

namespace Packimpex\ContentManager\Strategies;

use Packimpex\ContentManager\Domain\File;
use Packimpex\ContentManager\Domain\Permission;
use Packimpex\ContentManager\Domain\User;

/*
 * This strategy handles upload of a file.
 * It saves the corresponding entry to the database and
 * delegates physical upload to the file transfer manager.
 * At the moment only one file can be uploaded at a time !
 * An uploaded item can be shared with a transferee.
 */
class UploadStrategy
{
	/*  
	 * @param \Packimpex\ContentManager\FileManager $file_manager	
	 * @return void
	 */
	public function apply($file_manager)
	{
		$current_user = $file_manager->getCurrentUser();
		
		// performs upload
		$file_transfer_manager = $file_manager->getFileTransferManager();

		// checks if current user has permission to upload
		if (! $current_user->getHasUploadRight()) {
			throw new \Exception("You do not have permission to upload!");
		}
		
		
		
		// passes current module from file manager to file transfer manager
		//$file_transfer_manager->setModule($file_manager->getCurrentModule());
		
		// User either did not notice that the file exists or simply wanted to upload
		// a newer version of the file. In the last case he is hinted to use option Update
		/*
		if ($file_transfer_manager->fileAlreadyExists()) {
			throw new \Exception(
				"File with this name already exists!\n
				 Please change file's name or consider Update option!");
		}
		*/
		
		$mapper_factory = $file_manager->getMapperFactory();
		
		$content_mapper = $mapper_factory->contentMapper();
		
		$user_permission_mapper = $mapper_factory->userPermissionMapper();
		
		// TO-DO: get it via getter from $file_manager
		$request_registry = $file_manager->getRequestRegistry();
		
		$file = new File($file_transfer_manager->getFilename(),
						 null,
						 null,
						 $file_manager->getJobId(),
						 $file_manager->getModuleItemId());
						  
		$file->setOwner(new User($file_manager->getCurrentUserId()));
		
		$content_mapper->insert($file);
		/*
		array("filename" => $file_transfer_manager->getFilename(),
									 "path" => $file_transfer_manager->getDirPath(),
									 "bkg_id" => $file_manager->getModuleItemId(),
									 "user_id" => $file_manager->getCurrentUserId()));*/
									 
									 
		// If a user decided to share a content item with the transferee
		if ($request_registry->getShareWithTransferee()) {
			$transferee_id = $file_manager->getCurrentModule()->getTransferee()->getUserId();
						
			foreach ($request_registry->getTypes() as $type) {
				//echo $content_mapper->getLastItemId() . " " . $transferee_id . " " . $type;
				
				$permission = new Permission( 
											$file_manager->getCurrentModule()->getTransferee(),
											array($type));
											
				$permission->setContentItem($file);
				
				
				$user_permission_mapper->insert($permission);
				/*$user_permission_mapper->insert(array($content_mapper->getLastItemId(),
													$transferee_id, $type));*/
			}
		}
		
		//TO-DO: Transaction for file-upload;
		/*
		$this->file_mapper->insert($file);
		$this->upload_mapper->insert($file);
		*/
		//TO-DO:
		
		$file_transfer_manager->uploadFile();
	}
}