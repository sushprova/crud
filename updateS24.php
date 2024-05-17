<?php 

require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Update Post");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3>Update A Post</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"]) && isset($_GET["postId"]) && $_GET["postId"] !== "") {
		$stmt1 = $mysqli -> prepare("SELECT User_Id FROM Post WHERE Post_Id = ?;");
		$stmt1 -> execute([$_GET["postId"]]);
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {	
			$UserId = $row["User_Id"];
		}
	

		$stmt = $mysqli -> prepare("UPDATE Post SET Caption = ?, Picture = ?, Location = ?, Privacy =?  WHERE Post_Id = ?");
		$stmt -> execute([$_POST["caption"], $_POST["picture"],$_POST["location"], $_POST["privacy"], $_POST["postId"]]);


		// redirect('readS24Acc.php?userId=' . urlencode($UserId));


///////////////////////////////////////////////////////////////////////////////////////////

		//Output query results and return to read.php			
		if($stmt) {
			$_SESSION["message"] = "Post has been changed";
		}
		else {
			$_SESSION["message"] = "Error! Could not change post";
		}
		redirect('readS24Acc.php?userId=' . urlencode($UserId));
	}

	else {

		// $_SESSION["message"] = $id."has been changed";

///////////////////////////////////////////////////////////////////////////////////////////
// echo "<td><a href='updateS24.php?postId=".urlencode($postId)."'><img src='pencil_icon.jpg' alt='Edit' style='height: 30px; width: 30px;'></a></td>";
// the line above from readS24Acc gives me the postId below.
	  if (isset($_GET["postId"]) && $_GET["postId"] !== "") {

	  $stmt = $mysqli -> prepare("SELECT Post_ID, User_Id, Caption, Picture, Location, Privacy FROM Post WHERE Post_ID = ? ;");
	  $stmt -> execute([$_GET["postId"]]);
	  	
		if ($stmt)  {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$UserId = $row["User_Id"];


			// echo "<h3>".$row["title"]." Information</h3>";
			echo "<h3>" . "Post Information</h3>";
			?>

			<!-- <form method="POST" action="updateS24.php?postId=" $_GET["postId"]. "> -->
			<form method="POST" action="updateS24.php?postId=<?php echo $_GET["postId"]; ?>">

			<input type = 'hidden' name = 'postId' value ='<?php echo $row['Post_ID']; ?>'/>
			<p> Caption: <input type=text name="caption" value = "<?php echo $row['Caption']; ?>" ></p>
			<p> Picture: <input type=text name="picture" value = "<?php echo $row['Picture']; ?>" ></p>
			<p> Location: <input type=text name="location" value = '<?php echo $row['Location']; ?>'> </p>
			<p> Privacy: <?php echo $row['Privacy']; ?> </p>



			<p>Privacy:<select name="privacy">
				<option value='Public'>Public</option>
        		<option value='Private'>Private</option>
        		<option value='Friends Only'>Friends Only</option>
    		</select><br>
			</p>
				
				<input type="submit" name="submit" class="button tiny round" value="Edit Post" />
			</form>
	<?php




			
///////////////////////////////////////////////////////////////////////////////////////////

			// echo "<a href='createS24.php?userId=".urlencode($_GET["userId"])."'>Add a post</a>";
			echo "<br /><p>&laquo:<a href='readS24Acc.php?userId=".urlencode($UserId)."'>Back to Main Page</a>";

			echo "</label>";
			echo "</div>";
		}

		//Query failed. Return to readS24.php and output error
	else {
			$_SESSION["message"] = "Post could not be found!";
			redirect("readS24.php");
		}

	}

}
    
					

new_footer("Update posts ");
Database::dbDisconnect($mysqli);

?>