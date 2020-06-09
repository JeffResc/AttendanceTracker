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
   include("functions.php");
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
	  $myfname = mysqli_real_escape_string($db,$_POST['fname']);
	  $mylname = mysqli_real_escape_string($db,$_POST['lname']);
      $mypassword = mysqli_real_escape_string($db,$_POST['pword']); 
	  $salt = generateRandomString();
	  $hashedPass = hash('sha512', $salt . $mypassword);
	  $duplicateQuery = mysqli_query($db,"SELECT * FROM users WHERE username = '".$myusername."'");
	  if (mysqli_num_rows($duplicateQuery) < 1) {
		mysqli_query($db,"INSERT INTO users (username,fname,lname,password,salt,fulladmin) VALUES('".$myusername."','".$myfname."','".$mylname."','".$hashedPass."','".$salt."',0);");
	  }
    }
	header("location: /admins");
	if($db) { mysqli_close($db); }
?>