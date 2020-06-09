<?php
   include("database.php");
   include("functions.php");
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      $result = mysqli_query($db,"SELECT * FROM users WHERE username = '".$myusername."'");
      if(mysqli_num_rows($result) == 1) {
		$sessionData = mysqli_fetch_assoc($result);
		$sessionID = generateRandomString();
		mysqli_query($db,"UPDATE users SET session='".$sessionID."' WHERE username = '".$myusername."'");
		if (hash('sha512', $sessionData['salt'] . $mypassword) == $sessionData['password']) {
          $_SESSION['data'] = $sessionID;
          header("location: /panel");
		} else {
		  header("location: /?err=1");
		}
      } else {
        header("location: /?err=1");
      }
    } else {
	  header("location: /?err=3");
    }
	if($db) { mysqli_close($db); }
?>