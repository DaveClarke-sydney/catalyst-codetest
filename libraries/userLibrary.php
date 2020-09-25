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
        }

}

?>
