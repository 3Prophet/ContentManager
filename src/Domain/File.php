<?php

namespace Packimpex\ContentManager\Domain;

use Packimpex\ContentManager\Domain\AbstractFile;

class File extends AbstractFile
{
	protected $is_folder = FALSE;
	//private $permissions = NULL;
	protected $file_id = null;
	
	public function __construct($filename, $path, $file_id, $job_id, $module_id, $owner)
	{
		$this->name = $filename;
		$this->file_id = $file_id;
		$this->module_id = $module_id;
		$this->job_id = $job_id;
		$this->path = $path;
		$this->owner = $owner;
	}
	
	
	
	/*
	public function __construct($path, $name, $owner)
	{
		$dir_path = trim($path);
		$file_name = trim($name);
		
		$full_path = $dir_path . DIRECTORY_SEPARATOR . $file_name;
		
		if (!file_exists($dir_path)) {
			throw new Exception("Path does not exist!: $dir_name");
		}
		if (!is_dir($dir_path)) {
			throw new Exception("Not directory!: $dir_name");
		}
		if (!file_exists($full_path)) {
			throw new Exception("File $file_name does not exist in $dir_path");
		}
		if (!is_file($full_path)) {
			throw new Exception(
				"$file_name located in $dir_path is not a file!");
		}
		
		$this->path = split(DIRECTORY_SEPARATOR, $dir_name);
		$this->name = $dir_name;
		$this->owner = $owner;
	}
	*/
}