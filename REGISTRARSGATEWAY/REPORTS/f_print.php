<?php
ob_start();
include('../conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Registrar's Gateway</title>
<style>
<?php 
	require "../frame-css.txt"; 
	require "../list-table-css.txt";
?>
</style>
<script>
<?php
	require "../js-time.txt";
?>
</script>
<script src='../jquery.js'></script>
</head>
<body onload="startTime()">
<?php
if (!isset($_SESSION['id2'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem3']))
{
header('location:../chooseterm.php');
}
?>
<?php
	$id=$_SESSION['id2'];
	$sem=$_SESSION['sem3'];
$res=mysqli_query("SELECT * FROM registrar where ctr=$id") or die(mysqli_error());
$row=mysqli_fetch_array($res);
	$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
	$rows=mysqli_fetch_array($ress);

	$TERM = $_POST['TERM'];
	$sql_term = mysqli_query("SELECT * FROM semtbl WHERE id = '$TERM' ") or die(mysqli_error());
	$term = mysqli_fetch_array($sql_term);

	echo "<br><center><h2>Faculty Grades</h2><br>
	$term[syear] $term[sem]
	</center><br>";


	$sql = mysqli_query("SELECT * FROM schedule LEFT JOIN staff ON schedule.instructor = staff.ctr WHERE term = '$TERM' GROUP BY courseid ORDER BY instructor ") or die(mysqli_error());
	if(mysqli_num_rows($sql) > 0) {
		print "<table class='report-table1'>
					<tr head>
						<td>Name</td>
						<td>Schedule</td>
						<td>Subjects</td>
						<td>Status</td>
					</tr>";
		$count = 1;
		$Submitted = 'Yes';
		$Status = 'On Process';
		$key_STAFF = 0;
		while($data = mysqli_fetch_array($sql)) {
			if($key_STAFF == $data['instructor'] && $count > 1) {
				$SQLs = mysqli_query("SELECT * FROM grading_overscore WHERE term = '$TERM' AND courseid = '$data[courseid]'  AND grading = 'FINAL' AND finalposting = 'T' ") or die(mysqli_error());
						if(mysqli_num_rows($SQLs) > 0) {
							$Status = 'Submitted';
						}
						else {
							$Status = 'On Process';
						}

						?>
						<script>
							$(document).ready(function() {
								var Count = "<?php echo $count;?>";
								$('span#status'+Count).html('<?php echo $Status;?>');
							});
						</script>
						<?php
			}
			else {
			print "	<tr>
						<td>".$count++.".
						 $data[lname], $data[gname]</td>
						<td><a href='schedule.php?T=$data[ctr]&SEM=$TERM' target='_blank'>Schedule</a></td>
						<td><a href='subjects.php?T=$data[ctr]&SEM=$TERM' target='_blank'>Subjects</a></td>
						<td>";
						$SQL = mysqli_query("SELECT * FROM grading_overscore WHERE term = '$TERM' AND courseid = '$data[courseid]'  AND grading = 'FINAL' AND finalposting = 'T' ") or die(mysqli_error());
						if(mysqli_num_rows($SQL) > 0) {
							$Status = 'Submitted';
						}
						else {
							$Status = 'On Process';
						}
				print 	"<span id='status$count'>$Status</span></td>
					</tr>";
			}
			$key_STAFF = $data['instructor'];
		}
		echo "</table><br>";
	}
	else {
		echo "<table class='report-table1'><tr head><td>No Record</td></tr></table><br>";
	}
?>
</body>
</html>