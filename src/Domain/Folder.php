<?php
//TO-DO: Rewrite (Check File for example)
class Folder extends AbstractFile
{
	private $name = NULL;
	private $owner = NULL; // instance of User class
	private $is_folder = TRUE;
	private $path = NULL;
	private $permissions = NULL;
	
	private $content = array();
	
	public function __construct($path, $name, $owner)
	{
		$dir_path = trim($path);
		$dir_name = trim($name);
		
		$full_path = $dir_path . DIRECTORY_SEPARATOR . $dir_name;
		
		if (!file_exists($dir_path)) {
			throw new Exception("Path does not exist!: $dir_name");
		}
		if (!is_dir($dir_path)) {
			throw new Exception("Not directory!: $dir_name");
		}
		if (!file_exists($full_path)) {
			throw new Exception("Directory $dir_name does not exist in $dir_path");
		}
		if (!is_dir($full_path)) {
			throw new Exception(
				"$dir_name located in $dir_path is not a directory!");
		}
		
		$this->path = split(DIRECTORY_SEPARATOR, $dir_name);
		$this->name = $dir_name;
		$this->owner = $owner;
	}
	
	public function addToContent($generic_file)
	{
		if (!$this->contains($generic_file)) {
			array_push($this->content, $generic_file);
		}
	}
	
	public final function contains($generic_file)
	{
		$contains = FALSE;
		
		if (empty($this->content)) {
			return $contains;
		} 
		foreach ($this->content as $file) {
			if ($file->isEqual($generic_file)) {
				$contains = TRUE;
				break;
			}
		}
		return $contains;	
	}
	

}