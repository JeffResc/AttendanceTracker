<?php
include("database.php");
if ($_SESSION['data'] && isset($_POST['date']) && isset($_POST['id']) && isset($_POST['status'])) {
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
	  $mydate = mysqli_real_escape_string($db,$_POST['date']);
	  $mystatus = mysqli_real_escape_string($db,$_POST['status']);
      mysqli_query($db,"UPDATE record SET status='".$mystatus."' WHERE studentID='".$userID."' AND date='".$mydate."'");
    }
	header("location: /editrecord?id=".$userID."&date=".$mydate);
	if($db) { mysqli_close($db); }
?>