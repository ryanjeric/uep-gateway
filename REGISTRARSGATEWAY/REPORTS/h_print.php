<?php
error_reporting(0);
ob_start();
include('conn.php');
session_start();

	$TERM = $_POST['TERM'];
	$sql = mysqli_query("SELECT * FROM semtbl WHERE id = '$TERM' ") or die(mysqli_error());
	if(mysqli_num_rows($sql)>0) {
	$term = mysqli_fetch_array($sql);
	}

	$COURSE = $_POST['COURSE'];
	$SQL = mysqli_query("SELECT * FROM coursetbl WHERE id = '$COURSE' ") or die(mysqli_error());
	if(mysqli_num_rows($SQL)>0) {
	$course = mysqli_fetch_array($SQL);
	}
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
?>
<br>
<span tenpercent>
<center><h2>Changed Grades</h2>
<b>School Year: </b><?php echo "$term[syear] $term[sem]";?> <br>
</center>
</span>
<br><br>
<?php


	$sql = mysqli_query("SELECT * FROM changegrade LEFT JOIN coursetbl ON changegrade.coursecode = coursetbl.coursecode WHERE sem = '$TERM' ORDER BY datechange DESC ") or die(mysqli_error());
	if(mysqli_num_rows($sql) > 0) {
		print "<table class='report-table1'>
				<tr head>
					<td></td>
					<td>OR#</td>
					<td>Course Code</td>
					<td>Course Description</td>
					<td>Date Changed</td>
				</tr>";
		$rounds = 1;
		while($data = mysqli_fetch_array($sql)) {
			print "<tr>
						<td>".$rounds++."</td>
						<td>$data[OR]</td>
						<td>$data[coursecode]</td>
						<td>$data[coursedesc]</td>
						<td>$data[datechange]</td>
					</tr>";
		}
		echo "</table><br>";
	}
?>
<br><br>
</div>
</div>
</body>
</html>