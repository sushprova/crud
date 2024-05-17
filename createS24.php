<?php 

require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Create a new post"); 
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
	echo $output;
}
echo "<center>"; 
	echo "<h3>Add a Post</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"]) && isset($_GET["userId"]) && $_GET["userId"] !== "") {
		$stmt = $mysqli -> prepare("SELECT User_Id FROM User WHERE User_Id = ?;");
		$stmt -> execute([$_GET["userId"]]);
		
		$UserId = -1;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {	
			$UserId = $row["User_Id"];
		}

		if($UserId > 0) {
			
			$Location = $_POST["location"];
			$Privacy = $_POST["privacy"];
			$Caption = $_POST["caption"];
			$Image = $_POST["picture"];
			$Location = $_POST["location"];
			$Privacy = $_POST["privacy"];
			
			date_default_timezone_set('America/Chicago');
			$DateTime = date('Y-m-d H:i:s');
			
			$stmt2 = $mysqli -> prepare("
				INSERT INTO Post (User_Id,Caption,Picture,Date_posted, Location, Privacy) VALUES (?, ?, ?, ?, ?, ?)");
			// echo $UserId;
			// echo $Caption;
			// echo $Image;
			$stmt2 -> execute([$UserId, $Caption, $Image, $DateTime, $Location, $Privacy]);
			
			if($stmt2){
				$_SESSION["message"] = "New post has been added";
			}else{
				$_SESSION["message"] = "Error adding post!";
			}
			redirect("readS24Acc.php?userId=".$UserId);
		}
		else {
			$_SESSION["message"] = "Unable to add post. Fill in all information!";
			redirect("createS24.php?userId".$UserId);
		}
	
	}
	else {
		echo "<form method='POST' action='createS24.php?userId=" . $_GET["userId"] . "'>";
		echo "Caption: <input type=text name='caption'>";
		echo "Image: <input type=text name='picture'>";
		echo "Location: <input type='text' name='location'>";
		echo "Post Privacy: 
			<select name='privacy'>
				<option value='Public'>Public</option>
				<option value='Private'>Private</option>
				<option value='Friends Only'>Friends Only</option>
			</select><br>";
		echo "<br>";
		echo "<br>";
		echo "<input type='submit' name='submit' class='button tiny round' value='Add a Post'/>";
		echo "</form>";
	}
	echo "</label>";
	echo "</div>";
	// echo "<br /><p>&laquo:<a href='readS24Acc.php'> Back to Post Info</a>";
	echo "<br /><p>&laquo:<a href='readS24Acc.php?userId=".urlencode($_GET["userId"])."'>Back to Main Page</a>";

	echo "</center>";

new_footer("Add a post ");
Database::dbDisconnect($mysqli);

?>