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
	  $userID = mysqli_real_escape_string($db,$_POST['id']);
	  $myfname = mysqli_real_escape_string($db,$_POST['fname']);
	  $mylname = mysqli_real_escape_string($db,$_POST['lname']);
	  $myphoto = mysqli_real_escape_string($db,$_POST['photo']);
      mysqli_query($db,"UPDATE class SET fname='".$myfname."', lname='".$mylname."', photo='".$myphoto."' WHERE id='".$userID."'");
    }
	header("location: /manageclass?id=".$_POST['username']."&updated=1");
	if($db) { mysqli_close($db); }
?>