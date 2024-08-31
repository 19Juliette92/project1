<?php
class Database {
	private string $host = 'localhost';
	private string $database = 'intelligate_v2';
	private string $user = 'root';
	private string $password = '';
	private ?PDO $connection = null;

	public function __construct() {
		$this->connect();
	}

	private function connect(): void {
		try {
			$this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]);
		} catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}

	public function getConnection(): ?PDO {
		return $this->connection;
	}
}
?>
