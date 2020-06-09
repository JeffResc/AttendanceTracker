<?php
include("database.php");
if ($_SESSION['data']) {
	$result = mysqli_query($db,"SELECT * FROM users WHERE session = '".$_SESSION['data']."'");
	if (mysqli_num_rows($result) == 1) {
		$sessionData = mysqli_fetch_assoc($result);
	} else {
		header("location: /?err=4");
		if($db) { mysqli_close($db); }
		die();
	}
} else {
	header("location: /?err=4");
	if($db) { mysqli_close($db); }
	die();
}
   if($_SERVER["REQUEST_METHOD"] == "POST") {
	  $myusername = mysqli_real_escape_string($db,$_POST['username']);
	  $currUser = mysqli_real_escape_string($db,$_POST['currUser']);
	  $myfname = mysqli_real_escape_string($db,$_POST['fname']);
	  $mylname = mysqli_real_escape_string($db,$_POST['lname']);
      mysqli_query($db,"UPDATE users SET username='".$myusername."', fname='".$myfname."', lname='".$mylname."' WHERE username='".$currUser."'");
    }
	header("location: /manage?user=".$_POST['username']."&updated=1");
	if($db) { mysqli_close($db); }
?>