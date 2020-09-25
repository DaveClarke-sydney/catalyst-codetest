<?php

require_once('./libraries/userLibrary.php');

class userController
{
	private $validOptions = [
		'--file', 
		'--create_table', 
		'--dry_run', 
		'-u', 
		'-p', 
		'-h', 
		'--help',
	];

	public function main($argc, $argv)
	{
		$userModel = new userModel();

		try {
			list($filename, $options) = $this->parseInput($argc, $argv);
		} catch (Exception $e) {
			echo $e->getMessage()."\n";
			return;
		}

		if(in_array('--help', $options))
		{
			$this->displayHelp();	
		} elseif(in_array('-u', $options))
		{
			echo userLibrary::displayUser()."\n";
		} elseif(in_array('-p', $options))
		{
			echo userLibrary::displayPassword()."\n";
		} elseif(in_array('-h', $options))
		{
			echo userLibrary::displayHost()."\n";
		} elseif(in_array('--create_table', $options))
		{
			$result = userLibrary::createTable();
			if($result) {
                        	echo "successfully created table\n";
                	} else {
                        	echo "unable to create table\n";
                	}
		} else {
			$dry_run = in_array('--dry_run', $options);
			try {
				userLibrary::processFile($filename, $dry_run);
			} catch(Exception $e) {
				echo $e->getMessage()."\n";
			}
		}
	}

	public function parseInput($argc, $argv)
	{
		$options = [];
		$filename = null;
		for ($i=1; $i < $argc; $i++) {
			if($argv[$i][0] == '-'){
				if($argv[$i] == '--file'){
					$i++;
					$filename = $argv[$i];
				} elseif(in_array($argv[$i], $this->validOptions)){
    					$options[] = $argv[$i];
				} else {
					throw new Exception("unrecognized option '{$argv[$i]}'");
				}
			} else {
				throw new Exception("malformed arguments");
			}
		}
		return [$filename, $options];
	}

	public function displayHelp()
	{
		$helpFilename = 'help.txt';
		$helpFile = file_get_contents($helpFilename);
		echo $helpFile."\n";
	}
}

(new userController())->main($argc, $argv);



/*
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
*/

?>
