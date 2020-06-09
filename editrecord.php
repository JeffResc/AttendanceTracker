<!DOCTYPE HTML>
<?php
include("include/database.php");
if ($_SESSION['data'] && isset($_GET['date']) && isset($_GET['id'])) {
	$result = mysqli_query($db,"SELECT * FROM users WHERE session = '".$_SESSION['data']."'");
	if (mysqli_num_rows($result) == 1) {
		$sessionData = mysqli_fetch_assoc($result);
		$specificRecord = mysqli_query($db,"SELECT * FROM record WHERE studentID = '".$_GET['id']."' AND date = '".$_GET['date']."'");
		$specificClass = mysqli_query($db,"SELECT * FROM class WHERE id = '".$_GET['id']."'");
		if (mysqli_num_rows($specificRecord) == 1 && mysqli_num_rows($specificClass) == 1) {
			$recordData = mysqli_fetch_assoc($specificRecord);
			$classData = mysqli_fetch_assoc($specificClass);
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
} else {
	header("location: /?err=4");
	if($db) { mysqli_close($db); }
	die();
}
?>
<html>
	<head>
		<title>Edit Record</title>
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
								<h2>Edit Record</h2>
							</header>
							<p><a href="/panel">Return Home</a> • <a href="/lookup">Return to Record Lookup</a></p>
							<br>
							<?php
							echo "<p>Editing Record For <strong>".$classData['fname']." ".$classData['lname']."</strong> on <strong>".$_GET['date']."</strong></p>";
							?>
							<form name="editRecord" method="POST" action="/include/editRecord.php">
							<input type="hidden" name="date" value="<?php echo $_GET['date']; ?>">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
							<select name="status">
							<?php
							if ($recordData['status'] == 3) {
								echo '<option value="3" selected>Present</option>';
							} else {
								echo '<option value="3">Present</option>';
							}
							if ($recordData['status'] == 2) {
								echo '<option value="2" selected>Tardy</option>';
							} else {
								echo '<option value="2">Tardy</option>';
							}
							if ($recordData['status'] == 1) {
								echo '<option value="1" selected>Absent</option>';
							} else {
								echo '<option value="1">Absent</option>';
							}
							?>
							</select>
							<input type="submit" value="Edit Record">
							</form>
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