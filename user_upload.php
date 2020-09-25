<?php

require_once('./models/userModel.php');

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
			$this->displayUser();
		} elseif(in_array('-p', $options))
		{
			$this->displayPassword();
		} elseif(in_array('-h', $options))
		{
			$this->displayHost();
		} elseif(in_array('--create_table', $options))
		{
			$this->createTableOnly();
		} else {
			$dry_run = in_array('--dry_run', $options);
			$this->processFile($filename, $dry_run);
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

	public function displayUser()
	{
		echo userModel::$username."\n";
	}

	public function displayPassword()
	{
		echo userModel::$password."\n";
	}

	public function displayHost()
	{
		echo userModel::$servername."\n";
	}

	public function createDatabaseOnly()
	{
		echo "creating Database only\n";
	}	

	public function processFile($filename, $dry_run)
	{
		if(substr($filename, -4) != '.csv'){
			throw new Exception('not a .csv file');
		}
		echo "processing file $filename\n";
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
