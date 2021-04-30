<?php

namespace app\database;
use \PDO;
use \PDOException;

class Database {

	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database_name = "attandance_system";

	public function connect() {
		try {
			$config = "mysql:host=" . $this->host.";dbname=" . $this->database_name;
			$pdo = new PDO($config, $this->user, $this->password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$pdo->setAttribute( PDO::MYSQL_ATTR_FOUND_ROWS, true);
			return $pdo;
		}catch(PDOException $e) {
			die("Database Connection failed". $e->getMessage());
		}
	}
}