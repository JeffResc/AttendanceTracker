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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$subStrang = substr($_POST['jsonString'], 0, -2);
	$subStrang .= "}";
	$parsed = json_decode($subStrang, true);
	$duplicateQuery = mysqli_query($db,"SELECT * FROM class WHERE date = '".date("Y")."-".date("m")."-".date("d")."'");
	if (mysqli_num_rows($duplicateQuery) < 1) {
		$classQuery = mysqli_query($db,"SELECT * FROM class ORDER BY lname");
		while ($data = $classQuery->fetch_assoc()) {
			mysqli_query($db,"INSERT INTO `record` (`studentID`,`status`,`date`) VALUES ('".$data['id']."','".$parsed[$data['id']]."','".date("Y")."-".date("m")."-".date("d")."')");
		}
	}
	header("location: /lookupDate?lookupDate=".date("Y")."-".date("m")."-".date("d"));
	if($db) { mysqli_close($db); }
} else {
	header("location: /attendance");
	if($db) { mysqli_close($db); }
}
?>