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
	  $myfname = mysqli_real_escape_string($db,$_POST['fname']);
	  $mylname = mysqli_real_escape_string($db,$_POST['lname']);
      $myphoto = mysqli_real_escape_string($db,$_POST['photo']);
	  $duplicateQuery = mysqli_query($db,"SELECT * FROM class WHERE fname = '".$fname."' AND lname = '".$lname."'");
	  if (mysqli_num_rows($duplicateQuery) < 1) {
		  mysqli_query($db,"INSERT INTO class (fname,lname,photo) VALUES('".$myfname."','".$mylname."','".$myphoto."');");
	  }
    }
	header("location: /class");
	if($db) { mysqli_close($db); }
?>