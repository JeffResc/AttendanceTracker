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
		<title>Record Lookup</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<!-- One -->
			<section id="one" class="main style1">
				<div class="container">
					<div class="row gtr-150">
						<div class="col-6 col-12-medium">
							<header class="major">
								<h2>Lookup By Date</h2>
							</header>
							<form name="lookupDate" method="GET" action="/lookupDate">
								<input type="date" name="lookupDate" value="<?php echo date("Y")."-".date("m")."-".date("d"); ?>">
								<br><br>
								<input type="submit" name="submit" value="Lookup by Date" id="submit">
							</form>
						</div>
						<div class="col-6 col-12-medium imp-medium">
							<header class="major">
								<h2>Lookup By Class Member</h2>
							</header>
							<form name="lookupName" method="POST" action="/lookupName">
								<select name="lookupID">
								<?php
								$classQuery = mysqli_query($db,"SELECT * FROM class ORDER BY lname");
								while ($data = $classQuery->fetch_assoc()) {
									echo '<option value="'.$data['id'].'">'.$data['lname'].', '.$data['fname'].'</option>';
								}
								?>
								</select>
								<br>
								<input type="submit" name="submit" value="Lookup by Name" id="submit">
							</form>
						</div>
					</div>
				</div>
			</section>

		<!-- Footer -->
			<section id="footer">
			<h3><a href="/panel">Home</a></h3><br>
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