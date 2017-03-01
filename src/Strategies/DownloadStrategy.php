<?php

namespace Packimpex\ContentManager\Strategies;

class DownloadStrategy
{
	public function apply($file_manager)
	{
		// checks if current user has permission to delete
		if (! $file_manager->getFileToEdit()->getIsViewable()) {
			throw new \Exception("You do not have permission to view this file!");
		}
		
		$file_manager->getFileTransferManager()->downloadFile();
	}
}