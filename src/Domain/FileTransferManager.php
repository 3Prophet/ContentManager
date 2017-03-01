<?php

namespace Packimpex\ContentManager\Domain; 

class FileTransferManager
{	
	private $content_manager = null;
	
	private $content_location = null;
	
	private $request_registry = null;
	
	private $filename = null;
	
	private $dirname = null;
	
	// file_array corresponds to $_FILES["fileToUpload_label"]
	private $file_to_upload_array = null;
	
	public function __construct($content_location)
	{
		$this->content_location = $content_location;
	}
	
	
	public function setContentLocation($content_location)
	{
		$this->content_location = $content_location;
	}
	
	public function setFilename($filename)
	{
		$this->filename = $filename;
	}
	
	public function setDirname($dirname)
	{
		$this->dirname = $dirname;
	}
	
	public function getDirPath()
	{
		return $this->content_location . DIRECTORY_SEPARATOR . $this->dirname;
	}
	
	public function getFilePath()
	{
		return $this->getDirPath() . DIRECTORY_SEPARATOR . $this->filename;
	}
	
	public function setFileToUploadArray($file_array)
	{
		$this->file_to_upload_array = $file_array;
	}
	
		
	public function uploadFile()
	{
		// Throws exception if general content location directory for a job does not exist
		if (!(file_exists($this->content_location) or is_dir($this->content_location))) {
			throw new Exception("General content location directory is not set up.\nPlease contact developers !");
		}
		// Creates module directory if it does not exist
		if (!(file_exists($this->getDirPath()) or is_dir($this->getDirPath()))) {
			mkdir($this->getDirPath());
		}
		
		move_uploaded_file($this->file_to_upload_array["tmp_name"], $this->getFilePath());
		
	}
	

	public function deleteFile()
	{
		if (is_file($this->getFilePath())) {
			unlink($this->getFilePath());
		}
	}	
	
	public function getPath()
	{
		return $this->path;
	}
	
	public function getFilename()
	{
		return $this->filename;
	}
	


	public function downloadfile()
	{
		
		$filename = $this->getFilename();
		
		if (file_exists($this->getFilePath())) {
			//header('Content-Description: File Transfer'); no such thing in HTTP
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header('Expires: 0');
			header("Pragma: public");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");;
			header("Content-Length: " . filesize($this->getFilePath()));
			
			//set_time_limit(0);
			//$file = @fopen($target_fname)
			readfile($this->getFilePath());
			die();
		} else {
			die();
		}
		
	}
	/*
	public function dtest()
	{
		$db = IRSFactory::construct();
		//$db = array();
		$stmt = "SELECT * FROM users";					
		
		
		$s = $db->prepare($stmt);
		$s->execute();
		$o = $s->fetch(PDO::FETCH_OBJ);
		var_dump($o->user_id);
		
	}*/
	
	public function getBookingFiles($bkg_id)
	{
		$booking_dir = self::$usruploads . DIRECTORY_SEPARATOR . $bkg_id;
		if (file_exists($booking_dir)) {
			return array_diff(scandir($booking_dir), array('..', '.'));
		}
		return NULL;
	}
		
	
	
}