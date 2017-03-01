<?php

namespace Packimpex\ContentManager\Strategies;

class DeleteStrategy
{
	public function apply($file_manager)
	{
		// checks if current user has permission to delete
		if (! $file_manager->getFileToEdit()->getIsRemovable()) {
			throw new \Exception("You do not have permission to delete this file!");
		}
		// modifying database
		$module_mapper = $file_manager->getMapperFactory()->moduleMapper();
		$module_mapper->delete($file_manager->getFileToEdit(), 
								$file_manager->getCurrentUser());
		
		$file_manager->getFileTransferManager()->deleteFile();
	}
}