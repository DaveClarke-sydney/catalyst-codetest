<?php

require_once('./models/userModel.php');

$userModel = new userModel();

$records = [
	['name' => 'John', 'surname' => 'Smith', 'email' => 'john@smith.com'],
	['name' => 'Sherlock', 'surname' => 'Holmes', 'email' => 'sherlock@holmes.com'],
];
$userModel->batchInsert($records);
$result = $userModel->selectAll();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
	  var_dump($row);
  }
} else {
  echo "0 results";
}

?>
