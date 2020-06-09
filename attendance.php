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
		<title>Attendance Tracker</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
		img {
			max-width: 200px;
			height: auto;
		}
		</style>
	</head>
	<body class="is-preload">
		<!-- One -->
			<section id="one" class="main style1">
				<div class="container">
					<div class="row gtr-150">
						<div class="col-6 col-12-medium">
							<header class="major">
								<h2>Take Attendance</h2>
							</header>
							<a href="/panel">Go Home</a>
							<form name="attendance" id="attendanceForm" method="POST" action="/include/submitAttendance.php">
							<?php
							$result = mysqli_query($db,"SELECT * FROM record WHERE date = '".date("Y")."-".date("m")."-".date("d")."'");
							if (mysqli_num_rows($result) > 0) {
								echo "<p>Attendance Already Taken For ".date("l").", ".date("F")." ".date("j").date("S").", ".date("Y").".</p>";
								echo '<input type="button" value="View Record" onclick="viewRecord()" />';
							} else {
								echo "<p>Taking Attendance For ".date("l").", ".date("F")." ".date("j").date("S").", ".date("Y").".</p>";
								echo '<input type="button" value="Mark All As Present" onclick="allPresent()" /><br>';
								echo "<table width=\"100%\">";
								$classQuery = mysqli_query($db,"SELECT * FROM class ORDER BY lname");
								while ($data = $classQuery->fetch_assoc()) {
									echo '<tr><td><img src="'.$data['photo'].'"></td><td><td>'.$data['fname'].' '.$data['lname'].'</td><td><input type="button" name="'.$data['id'].'" value="Present" onclick="buttonActive(\''.$data['id'].'\', 3)" id="3" /></td><td><input type="button" name="'.$data['id'].'" value="Tardy" onclick="buttonActive(\''.$data['id'].'\', 2)" id="2" /></td><td><input type="button" name="'.$data['id'].'" value="Absent" onclick="buttonActive(\''.$data['id'].'\',1)" id="1" /></td></tr>';
								}
								echo '</table><input type="button" value="Submit Attendance" onclick="submitAttendance()" /><input type="hidden" name="jsonString" value="{}">';
							}
							?>
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
			<script>
			function buttonActive(id, status) {
				$('input[type=button][name='+id+']').removeClass('active');
				$('input[type=button][name='+id+'][id='+status+']').addClass('active');
			}
			function submitAttendance() {
				var jsonString = "{";
				$('[class=active]').each(function() {
					jsonString += '"'+$(this).attr('name')+'": "'+$(this).attr('id')+'", ';
				});
				$('input[name=jsonString]').val(jsonString);
				document.getElementById("attendanceForm").submit();
			}
			function viewRecord() {
				var MyDate = new Date();
				var MyDateString = MyDate.getFullYear() + '-' + ('0' + (MyDate.getMonth()+1)).slice(-2) + '-' + ('0' + MyDate.getDate()).slice(-2);
				window.open("/lookupDate?lookupDate="+MyDateString,"_self");
			}
			function allPresent() {
				$('input[type=button][id=1]').removeClass('active');
				$('input[type=button][id=2]').removeClass('active');
				$('input[type=button][id=3]').addClass('active');
			}
			</script>
	</body>
</html>
<?php if($db) { mysqli_close($db); } ?>