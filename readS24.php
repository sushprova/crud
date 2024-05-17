<?php 
	require_once("session.php"); 
	require_once("./included_functions.php");
	require_once("database.php");

	new_header("Account Info"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	
	//****************  Add Query
	//  Prepare and execute query
	$stmt = $mysqli -> prepare("SELECT User.User_Id, CONCAT(User.First_Name, ' ', User.Last_Name) AS Name, COUNT(Post.Post_Id) AS Num_Posts
	FROM User
	NATURAL JOIN Post
	GROUP BY User.User_Id
	ORDER BY Num_Posts DESC;");
	$stmt -> execute();
				
				
///********************    Uncomment Once Code Completed  **************************  

	if ($stmt) {
		echo "<div class='row'>";
		echo "<center>";
		echo "(Aggregate)Total number of posts of each user: SELECT User.User_Id, User.First_Name, User.Last_Name, COUNT(Post.Post_Id) AS Num_Posts
		FROM User
		NATURAL JOIN Post
		GROUP BY User.User_Id
		ORDER BY Num_Posts DESC;";

		echo "<h2>Account Info</h2>";
		echo "<table>";
		echo "  <thead>";
		// The first and last <td> are empty headings for the icons
		echo "     <tr><td style='text-align:center'>Name<br />(Click to see followers' posts)</td><td style='text-align:center'>Num of Posts<br />(Click to view posts)</td></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//////////// ADD CODE HERE
			// Retrieve information from query results			
			$userId= $row["User_Id"];
			
			//// ADD CODE HERE
			echo "<tr>";
			echo "<td style='text-align:center'><a href='postS24.php?userId=". urlencode($userId) . "'>" . $row["Name"]."</a></td>";

			// echo "<td><a href='updateS24.php?id=".urlencode($songId)."'><img src='pencil_icon.jpg' alt='Edit' style='height: 30px; width: 30px;'></a></td>";
			echo "<td style='text-align:center'><a href='readS24Acc.php?userId=" . urlencode($userId) . "'>" . $row["Num_Posts"] . "</a></td>";

			
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
		/////////////////  ADD CODE HERE
		echo "<br /><br />";

		// echo "<a href='createS24.php'>Add a Top 40 song</a>";

		echo "</center>";
		echo "</div>";
	}


	$stmt1 = $mysqli -> prepare("SELECT CONCAT(User.First_Name, ' ', User.Last_Name) AS Name,
	GROUP_CONCAT(Post.Date_posted SEPARATOR ', ') AS Posted_Dates
	FROM User
	NATURAL JOIN Post 
	GROUP BY User.User_Id;");
	$stmt1 -> execute();

	if ($stmt1) {
		echo "<div class='row'>";
		echo "<center>";
		echo "(Dr. Davidsons's)Dates of all posts of each user:SELECT CONCAT(User.First_Name, ' ', User.Last_Name) AS Name,
		GROUP_CONCAT(Post.Date_posted SEPARATOR ', ') AS Posted_Dates
		FROM User
		NATURAL JOIN Post 
		GROUP BY User.User_Id;";
		echo "<h2>Post Dates</h2>";
		echo "<table>";
		echo "  <thead>";
		// The first and last <td> are empty headings for the icons
		echo "     <tr><td style='text-align:center'>Name</td><td style='text-align:center'>Dates Posted</td></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {			
			
			//// ADD CODE HERE
			echo "<tr>";
			echo "<td style='text-align:center'>"." ".$row["Name"]."</td>";
			echo "<td style='text-align:center'>"." ".$row["Posted_Dates"]."</td>";


			
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
		/////////////////  ADD CODE HERE
		echo "<br /><br />";
		
		// echo "<a href='createS24.php'>Add a Top 40 song</a>";

		echo "</center>";
		echo "</div>";
	}
	

/************       Uncomment Once Code Completed For This Section  ********************/
	new_footer("Account Info ");	
	Database::dbDisconnect($mysqli);
 ?>