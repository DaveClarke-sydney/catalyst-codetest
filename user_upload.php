<?php

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


$sql = "SELECT * FROM users";
$result = $conn->query($sql);

var_dump($result);

?>
