<?php

class Database {

	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database_name = "attandance_system";

	protected function connect() {
		try {
			$config = "mysql:host=" . $this->host.";dbname=" . $this->database_name;
			$pdo = new PDO($config, $this->user, $this->passsword);
			$pdo->setAttribute([PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_FOUND_ROWS => true]);
			return $pdo;
		}catch(PDOException $e) {
			die("Database Connection failed". $e->getMessage());
		}
	}
}