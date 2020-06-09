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
	if(isset($_GET['id'])) { 
	  $userID = mysqli_real_escape_string($db,$_GET['id']);
      mysqli_query($db,"DELETE FROM class WHERE id='".$userID."'");
	  mysqli_query($db,"DELETE FROM record WHERE studentID='".$userID."'");
	}
	header("location: /class");
	if($db) { mysqli_close($db); }
?>