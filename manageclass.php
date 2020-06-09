<!DOCTYPE HTML>
<?php
include("include/database.php");
if ($_SESSION['data'] && isset($_GET['id'])) {
	$result = mysqli_query($db,"SELECT * FROM users WHERE session = '".$_SESSION['data']."'");
	if (mysqli_num_rows($result) == 1) {
		$sessionData = mysqli_fetch_assoc($result);
		$manageQuery = mysqli_query($db,"SELECT * FROM class WHERE id = '".$_GET['id']."'");
		if (mysqli_num_rows($manageQuery) == 1) {
			$managedUser = mysqli_fetch_assoc($manageQuery);
		} else {
			header("location: /class");
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
?>
<html>
	<head>
		<title>Manage Class Member</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
			<section id="one" class="main style1">
				<div class="container">
					<div class="row gtr-150">
						<div class="col-6 col-12-medium">
							<header class="major">
								<h2>Manage <?php echo $managedUser['fname']; ?></h2>
							</header>
							<p><a href="/class">Return To Manage Class Members</a> • <a href="/include/deleteClass.php?id=<?php echo $managedUser['id']; ?>">Delete Class Member</a></p>
							<form name="updateClass" method="POST" action="/include/updateClass.php">
							<input type="hidden" name="id" value="<?php echo $managedUser['id']; ?>">
							<input type="text" name="fname" value="<?php echo $managedUser['fname']; ?>">
							<input type="text" name="lname" value="<?php echo $managedUser['lname']; ?>">
							<input type="text" name="photo" value="<?php echo $managedUser['photo']; ?>">
							<input type="submit" value="Update Class Member">
							</form>
							<?php
							if(isset($_GET['updated']) && $_GET['updated'] == 1) { 
								echo "<p>Class member successfully updated!</p>";
							}
							?>
						</div>
					</div>
				</div>
			</section>

		<!-- Footer -->
			<section id="footer">
				<ul class="icons">
					<li><a href="//github.com/JeffResc/AttendanceTracker" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
				</ul>
				<ul class="copyright">
					<li>&copy;2018 Jeff Rescignano</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
				</ul>
			</section>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
<?php if($db) { mysqli_close($db); } ?>