<?php

namespace Packimpex\ContentManager\Database;

class PDOSingleton
{
	private static $PDO = NULL;
	
	private function __construct($dsn)
	{
		
		$host = $dsn['host'];
		$user = $dsn['user'];
		$pass = $dsn['pass'];
		$dbname = $dsn['name'];
		
		try {
			self::$PDO = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
								$user, $pass);
			self::$PDO->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION);
		}
		catch(\PDOException $e) {
			echo "Database connection failed.";
			throw $e;
			exit;
		}
	}
	
	public static function construct($dsn)
	{
		if (self::$PDO == NULL) {
			new self($dsn);
		}
		return self::$PDO;
	}
}
