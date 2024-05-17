<?php 


require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Delete Post");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



	if (($output = message()) !== null) {
		echo $output;
	}


	
  	if (isset($_GET["postId"]) && $_GET["postId"] !== "") {
//////////////////////////////////////////////////////////////////////////////////////				
	  $stmt = $mysqli -> prepare("DELETE FROM Post WHERE Post_Id=?");
	  $stmt -> execute([$_GET["postId"]]);
  
		if ($stmt) {
			$_SESSION["message"] = "Post successfully deleted";		
		}
		else {
			$_SESSION["message"] = "Post could not be deleted";

		}
		
		//************** Redirect to readS24.php

		
//////////////////////////////////////////////////////////////////////////////////////				
	}
	else {
		$_SESSION["message"] = " The post could not be found!";
		redirect("readS24.php");
	}

			

redirect("readS24.php");
new_footer("Top 40 Songs ");
Database::dbDisconnect($mysqli);


?>