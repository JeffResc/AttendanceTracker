<!DOCTYPE HTML>
<?php
include("include/database.php");
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
?>
<html>
	<head>
		<title>Manage Administrator Accounts</title>
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
								<h2>Manage Administrator Accounts</h2>
							</header>
							<p><a href="/panel">Return Home</a> • <a href="/addadmin">Add Administrator</a></p>
							<table width="100%">
							<?php
							if ($sessionData['fulladmin'] == 1) {
								echo "<tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Actions</th><th>Password</th></tr>";
							} else {
								echo "<tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Actions</th></tr>";
							}
							$adminQuery = mysqli_query($db,"SELECT * FROM users ORDER BY username");
							while ($data = $adminQuery->fetch_assoc()) {
								if ($sessionData['fulladmin'] == 1) {
									echo '<tr><td>'.$data['username'].'</td><td>'.$data['fname'].'</td><td>'.$data['lname'].'</td><td><a href="/manage?user='.$data['username'].'">Manage</a></td><td><a href="/updatepass?user='.$data['username'].'">Update</a></td></tr>';
								} else {
									echo '<tr><td>'.$data['username'].'</td><td>'.$data['fname'].'</td><td>'.$data['lname'].'</td><td><a href="/manage?user='.$data['username'].'">Manage</a></td></tr>';
								}
							}
							?>
							</table>
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