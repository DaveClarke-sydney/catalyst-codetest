<?php

require_once('./models/userModel.php');

class userLibrary
{
	public static function displayUser()
        {
                return userModel::$username."\n";
        }

        public static function displayPassword()
        {
                return userModel::$password."\n";
        }

        public static function displayHost()
        {
                return userModel::$servername."\n";
        }

        public static function createTable()
        {
                $userModel = new userModel();
		$result = $userModel->createTable();
		return $result;
        }

        public static function processFile($filename, $dry_run)
        {
                if(substr($filename, -4) != '.csv'){
                        throw new Exception('not a .csv file');
                }
		$file = file_get_contents($filename);
		if(!$file){
			throw new Exception("unable to open file");	
		}

		list($records, $errors) = self::validateAndFormatFile($file);

		$userModel = new userModel();
		if(!$dry_run)
		{
			$userModel->createTable();
			if(!$result = $userModel->batchInsert($records)){
				throw new \Exception('Unable to insert into database');		
			}
		}
		return [$records, $errors];
	}

	private static function validateAndFormatFile($file)
	{
		$records = [];
		$emails = [];
		$errors = [];
		$lines = explode("\n", $file);
		foreach($lines as $line)
		{
			$fields = explode(",", $line);
			if(sizeof($fields) < 3){
				continue;
			}
			$record = [];
			//ASSUMPTION first and last names have the same constraints
			$record['name'] = self::formatName($fields[0]);
			$record['surname'] = self::formatName($fields[1]);
			$email = trim($fields[2]);
			if(self::validEmail($email) || $email == 'email'){
				$record['email'] = self::formatEmail($fields[2]);
			} else {
				//ASSUMPTION The requiresments state that no write to the 
				//database should happen if an invalid email is found. 
				//Assuming that this means no write should be done for 
				//just that entry
				$errors[] = "Invalid email '{$email}'";
				$record['email'] = null;
			}

			//ASSUMPTION no valid entry will have one of these fields empty
			if(!empty($record['name']) && 
				!empty($record['surname']) &&
				!empty($record['email']) &&
				//ASSUMPTION duplicate emails in a single batch should 
				//use first and ignore the others
				!in_array($record['email'], $emails))
			{
				$emails[] = $record['email'];
				$records[] = $record;
			}
		}

		return [$records, $errors];
	}

	private static function formatName($name)
	{
		$name = trim($name);
		//ASSUMPTION 'name' and 'surname' are not valid entries
		if($name == 'name' || $name == 'surname'){
			return null;
		}
		//ASSUMPTION only the first letter of each name will have to be capitalised
		//and not any other letters (O'connor and Dicaprio are assumed to be the 
		//correct capitalisation)
		$name = ucfirst(strtolower($name));
		return $name;
	}

	private static function formatEmail($email)
	{
		$email = trim($email);
		if(empty($email) || $email == 'email'){
			$email = null;
		}
		return $email;
	}	
		
	private static function validEmail($email)
	{
		$email = trim($email);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return false;
		}

		return true;
	}

}

?>
