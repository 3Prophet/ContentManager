<?php

/**
 * The following line will attempt to load the \Packimpex\ContentManager\Domain\File class
 * from /path_to_project/src/Domain/File.php:
 * 
 * new \Packimpex\ContentManager\Domain\File
 *
 * @param string $class The fully qualified class name
 * @return void
 */
 
 spl_autoload_register(function ($class) {
	 
	 // project-specific namespace prefix
	 $prefix = "Packimpex\\ContentManager\\"; 
	 
	 // base directory for the namespace prefix
	 $base_dir = __DIR__ . DIRECTORY_SEPARATOR ."src" . DIRECTORY_SEPARATOR;
	 
	 // does class use the namespace prefix
	 $len = strlen($prefix);
	 
	 if (strncmp($prefix, $class, $len) !== 0) {
		 // no, move to the next registered autoloader
		 return;
	 }
	 
	 // get the relative class name
 	$relative_class = substr($class, $len);
	
	// replace the namespace prefix with the base directory,
	// separators with direcotry separators, append .php
	$file = $base_dir . str_replace("\\", DIRECTORY_SEPARATOR, $relative_class) . ".php";
	
	// if file exists, require it
	if (file_exists($file)) {
		require $file;
	}
 });