<?php 

require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Followers' Posts");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

    if (isset($_GET["userId"]) && $_GET["userId"] !== "") {

        $stmt = $mysqli -> prepare("SELECT Email FROM User WHERE User_Id =?");
        $stmt -> execute([$_GET["userId"]]);

        $email= "x";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {		
			$email= $row["Email"];
        }
        // echo $email;

        $stmt1 = $mysqli -> prepare("SELECT Post.Post_Id, Post.Caption
        FROM Post
        WHERE Post.User_Id IN (
            SELECT Follower_Id
            FROM Follower f
            INNER JOIN User u on u.User_Id = f.User_Id
            WHERE u.Email = ?)");

        $stmt1 -> execute([$email]);


        if ($stmt1) {
            echo "<div class='row'>";
            echo "<center>";
            echo "(Nested)Displays all posts of user's followers: SELECT Post.Post_Id, Post.Caption
            FROM Post
            WHERE Post.User_Id IN (
                SELECT Follower_Id
                FROM Follower f
                INNER JOIN User u on u.User_Id = f.User_Id
                WHERE u.Email = 'john@example.com'
            )";
            echo "<h2>Posts of Followers</h2>";
            echo "<table>";
            echo "  <thead>";
            echo "  <tr><td>Post_Id</td><td style='text-align:center'>Caption</td></tr>";
            echo "  </thead>";
            echo "  <tbody>";
            while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {			
                // $postId= $row["Post_Id"];

                echo "<tr>";
                echo "<td style='text-align:center'>"." ".$row["Post_Id"]."</td>";
                echo "<td style='text-align:center'>"." ".$row["Caption"]."</td>";
                
                echo "</tr>";
            }
            echo "  </tbody>";
            echo "</table>";
            echo "<br /><br />";
            
            // echo "<a href='createS24.php?userId=".urlencode($_GET["userId"])."'>Add a post</a>";
            // echo "<br /><br />";

            echo "<br /><p>&laquo:<a href='readS24.php'> Back to Home Page</a>";

            echo "</center>";
            echo "</div>";
        

    }


    }
    
/************       Uncomment Once Code Completed For This Section  ********************/
	new_footer("Post Info of Followers ");	
	Database::dbDisconnect($mysqli);
 ?>