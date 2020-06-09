<!DOCTYPE HTML>
<?php
include("include/database.php");
if ($_SESSION['data'] && isset($_POST['lookupID'])) {
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
$personDetails = mysqli_query($db,"SELECT * FROM class WHERE id = '".$_POST['lookupID']."'");
$details = mysqli_fetch_assoc($personDetails)
?>
<html>
	<head>
		<title><?php echo $details['fname']." ".$details['lname']; ?></title>
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
								<h2>Records for <?php echo $details['fname']." ".$details['lname']; ?></h2>
							</header>
							<p><a href="/panel">Return Home</a></p>
							<table width="100%">
							<tr><th>Date</th><th>Status</th><th>Edit</th></tr>
							<?php
							$userQuery = mysqli_query($db,"SELECT * FROM record WHERE studentID = '".$_POST['lookupID']."'");
							$total = 0;
							$present = 0;
							$tardy = 0;
							$absent = 0;
							while ($data = $userQuery->fetch_assoc()) {
								if ($data['status'] == 1) {
									$status = "Absent";
									$absent = $absent + 1;
								} else if ($data['status'] == 2) {
									$status = "Tardy";
									$tardy = $tardy + 1;
								} else if ($data['status'] == 3) {
									$status = "Present";
									$present = $present + 1;
								} else {
									$status = "Unknown";
								}
								$total = $total + 1;
								echo '<tr><td>'.$data['date'].'</td><td>'.$status.'</td><td><a href="/editrecord?id='.$_POST['lookupID'].'&date='.$data['date'].'">Edit</a></td></tr>';
							}
							?>
							</table>
							</div>
							<?php
							if (mysqli_num_rows($userQuery) < 1) {
								echo "<p>No records found.</p>";
							} else {
							?>
						<script>
							window.onload = function() {
							var chart = new CanvasJS.Chart("chartContainer", {
								animationEnabled: true,
								title: {
									text: "<?php echo $details['fname']." ".$details['lname']; ?>"
								},
								data: [{
									type: "pie",
									startAngle: 240,
									yValueFormatString: "##0.00\"%\"",
									indexLabel: "{label} {y}",
									dataPoints: [
									<?php if ($present != 0) { ?>
										{y: <?php echo ($present / $total) * 100; ?>, label: "Present (<?php echo $present; ?>)", color: "green"},
									<?php } ?>
									<?php if ($tardy != 0) { ?>
										{y: <?php echo ($tardy / $total) * 100; ?>, label: "Tardy (<?php echo $tardy; ?>)", color: "yellow"},
									<?php } ?>
									<?php if ($absent != 0) { ?>
										{y: <?php echo ($absent / $total) * 100; ?>, label: "Absent (<?php echo $absent; ?>)", color: "red"}
									<?php } ?>
									]
								}]
							});
							chart.render();
							}
						</script>
						<div class="col-6 col-12-medium imp-medium">
						<div id="chartContainer" style="height: 370px; width: 100%;"></div>
						</div>
						<?php } ?>
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
			<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

	</body>
</html>
<?php if($db) { mysqli_close($db); } ?>