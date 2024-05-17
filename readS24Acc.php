<?php 

require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("All Posts");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	// echo "<h3>All posts of user</h3>";
	// echo "<div class='row'>";
	// echo "<label for='left-label' class='left inline'>";

    if (isset($_GET["userId"]) && $_GET["userId"] !== "") {
        // $_SESSION["message"] = "bleh!";


        $stmt = $mysqli -> prepare("SELECT User.User_Id, CONCAT(User.First_Name, ' ', User.Last_Name) AS Name, Post.Post_Id, Post.Caption, Post.Picture, Post.Date_posted,Post.Location, Post.Privacy
        FROM Post
        INNER JOIN User ON Post.User_Id = User.User_Id
        WHERE User.User_Id = ?;");
        $stmt -> execute([$_GET["userId"]]);

        // echo "Query executed successfully.<br>";
        // echo "<script>alert('ID is set: $id');</script>";


        if ($stmt) {
            echo "<div class='row'>";
            echo "<center>";
            echo "<h2>Post Info of User</h2>";
            echo "<table>";
            echo "  <thead>";
            // The first and last <td> are empty headings for the icons
            echo "     <tr><td></td><td>Name</td><td>Caption</td><td>Image</td><td>Date Posted</td><td>Location</td><td>Privacy Setting</td><td></td></tr>";
            echo "  </thead>";
            echo "  <tbody>";
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {			
                $postId= $row["Post_Id"];

                //// ADD CODE HERE
                echo "<tr>";
                echo "<td><a href='deleteS24.php?postId=".urlencode($postId)."'onclick='return confirm(\"Are you sure you want to delete?\");'><img src='red_x_icon.jpg' alt='Delete' style='height: 15px; width: 15px;'></a></td>";
                echo "<td style='text-align:center'>"." ".$row["Name"]."</td>";
                echo "<td style='text-align:center'>"." ".$row["Caption"]."</td>";
                echo "<td style='text-align:center'>"." ".$row["Picture"]."</td>";
                echo "<td style='text-align:center'>"." ".$row["Date_posted"]."</td>";
                echo "<td style='text-align:center'>"." ".$row["Location"]."</td>";
                echo "<td style='text-align:center'>"." ".$row["Privacy"]."</td>";
                echo "<td><a href='updateS24.php?postId=".urlencode($postId)."'><img src='pencil_icon.jpg' alt='Edit' style='height: 30px; width: 30px;'></a></td>";
                // echo "<td style='text-align:center'><a href='your_link_here'>" . $row["Posted_Dates"] . "</a></td>";
    
    
                
                echo "</tr>";
            }
            echo "  </tbody>";
            echo "</table>";
            /////////////////  ADD CODE HERE
            echo "<br /><br />";
            
            echo "<a href='createS24.php?userId=".urlencode($_GET["userId"])."'>Add a post</a>";
            echo "<br /><br />";

            echo "<br /><p>&laquo:<a href='readS24.php'> Back to Home Page</a>";

            echo "</center>";
            echo "</div>";
        }




    }
    
/************       Uncomment Once Code Completed For This Section  ********************/
	new_footer("Post Info ");	
	Database::dbDisconnect($mysqli);
 ?>