<?php
error_reporting(0);
ob_start();
include('../conn.php');
session_start();
$staff_ID = $_POST['staff_ID'];
$SEM = $_POST['SEM'];

$sql_staff = mysqli_query("SELECT * FROM staff WHERE ctr = '$staff_ID' ") or die(mysqli_error());
$staff = mysqli_fetch_array($sql_staff);

$sql_sem = mysqli_query("SELECT * FROM semtbl WHERE id = '$SEM' ") or die(mysqli_error());
$sem_SY = mysqli_fetch_array($sql_sem);
?>
<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php 
	require "../frame-css.txt"; 
	require "../list-table-css.txt";
?>
</style>
<script src='../jquery.js'></script>
</head>
<body onload="startTime()">
<?php
if (!isset($_SESSION['id'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:../chooseterm.php');
}
?>
<?php
	$id=$_SESSION['id'];
	$sem=$_SESSION['sem'];
	$res=mysqli_query("SELECT * FROM user where id=$id") or die(mysqli_error());
	$row=mysqli_fetch_array($res);
	$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
	$rows=mysqli_fetch_array($ress);
?>
<br>
<center>
<h2>Faculty Subjects</h2>
</center>

<span tenpercent>
	<b>Instructor:</b> <?php echo $staff['lname'] . ", $staff[gname]"; ?> <br>
	<b>School Year:</b> <?php echo $sem_SY['syear'] . " $sem_SY[sem]"; ?>
</span><br><br>
<table class='report-table1'>
	<tr head>
		<td></td>
		<td>Subj Code</td>
		<td>Subj Description</td>
		<td>Grades</td>
	</tr>
	<?php
	$sql = mysqli_query("SELECT * FROM schedule LEFT JOIN  coursetbl ON schedule.courseid = coursetbl.id WHERE term = '$SEM' AND instructor = '$staff_ID' GROUP BY courseid ") or die(mysqli_error());
	$rounds = 1;
	while($data = mysqli_fetch_array($sql)) {
		$TERM = $data['term'];
		$COURSE = $data['courseid'];
	
		print "<tr>
					<td>".$rounds++."</td>
					<td>$data[coursecode]</td>
					<td>$data[coursedesc]</td>
					<td><a href='prelimgrade.php?term=$TERM&course=$COURSE' buttonlike>Prelim</a>
					<a href='midtermgrade.php?term=$TERM&course=$COURSE' buttonlike>Midterm</a>
					<a href='prefinalgrade.php?term=$TERM&course=$COURSE' buttonlike>Prefinal</a>
					<a href='finalgrade.php?term=$TERM&course=$COURSE' buttonlike>Final</a>
					<a href='gradesheet.php?term=$TERM&course=$COURSE' buttonlike>Gradesheet</a>
					</td>
				</tr>";
	
	}
	print "</table><br>";
	?>
</table>
<br>
</body>
</html>