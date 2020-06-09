<?php
include("database.php");
if ($_SESSION['data']) {
	$result = mysqli_query($db,"SELECT * FROM users WHERE session = '".$_SESSION['data']."'");
	if (mysqli_num_rows($result) == 1) {
		$sessionData = mysqli_fetch_assoc($result);
		if ($sessionData['fulladmin'] == 0) {
			header("location: /admins");
			if($db) { mysqli_close($db); }
			die();
		}
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
	  $currUser = mysqli_real_escape_string($db,$_POST['currUser']);
	  $mypword = mysqli_real_escape_string($db,$_POST['pword']);
	  $salt = generateRandomString();
	  $hashedPass = hash('sha512', $salt . $mypword);
      mysqli_query($db,"UPDATE users SET password='".$hashedPass."', salt='".$salt."' WHERE username='".$currUser."'");
    }
	header("location: /updatepass?user=".$_POST['username']."&updated=1");
	if($db) { mysqli_close($db); }
?>