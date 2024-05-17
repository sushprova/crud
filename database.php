<?php
class Database {
  public function __construct() {
    die('Init function error');
  }

  public static function dbConnect() {
	$mysqli = null;
	//try connecting to your database
	
	//catch a potential error, if unable to connect
  require_once("/home/sphalder/DBhalder.php");

    if($mysqli == null) {
        try {
            $mysqli = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, USERNAME, PASSWORD);
            echo "Successful Connection";
        }
        catch(PDOException $e) {
            echo "Could not connect";
            die($e->getMessage());
        }
    }


 
    return $mysqli;
  }

  public static function dbDisconnect() {
    $mysqli = null;
  }
}
?>
