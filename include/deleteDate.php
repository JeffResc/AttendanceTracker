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
	if(isset($_GET['date'])) { 
	  $userID = mysqli_real_escape_string($db,$_GET['date']);
	  mysqli_query($db,"DELETE FROM record WHERE date='".$_GET['date']."'");
	  header("location: /lookupDate?lookupDate=".$_GET['date']);
	} else {
		header("location: /lookup");
	}
	if($db) { mysqli_close($db); }
?>