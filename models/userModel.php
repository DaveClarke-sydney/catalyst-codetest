<?php

class userModel
{
	public $db;

	//ASSUMPTION - anyone who wants to configure database 
	//credentials will have access to this file.
	public static $servername = "localhost";
	public static $username = "testuser";
	public static $password = "password";
	public static $dbname = "catalyst";
	

	public function __construct()
	{
		$this->db = self::setupDb();
	}

	public static function setupDb()
	{
		// Create connection
		$conn = new mysqli(self::$servername,
			self::$username, 
			self::$password, 
			self::$dbname);

		// Check connection
		if ($conn->connect_error) {
 			die("Connection failed: " . $conn->connect_error);
		}
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
