<?php

class userModel
{
	public $db;

	public function __construct()
	{
		$this->db = self::setupDb();
	}

	public static function setupDb()
	{
		$servername = "localhost";
		$username = "testuser";
		$password = "password";
		$dbname = "catalyst";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
 			die("Connection failed: " . $conn->connect_error);
		}
		echo "Connected successfully\n";
		return $conn;
	}

	public function selectAll()
	{
		$sql = "SELECT * FROM users";
		$result = $this->db->query($sql);
		return $result;
	}

	public function batchInsert($records)
	{
		$values = [];
		foreach($records as $record)
		{
			$name = $record['name'];
			$surname = $record['surname'];
			$email = $record['email'];

			$value = "('$name', '$surname', '$email')";
			$values[] = $value;
		}

		$values = implode(",", $values);
		$sql = "INSERT INTO users (name, surname, email) VALUES $values";
		$result = $this->db->query($sql);
		return $result;
	}	

}
