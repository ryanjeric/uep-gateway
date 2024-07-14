<?php
error_reporting(0);
ob_start();
include('../conn.php');
session_start();

$TERM = $_POST['TERM'];
$sql_term = mysqli_query("SELECT * FROM semtbl WHERE id = '$TERM' ") or die(mysqli_error());
$term = mysqli_fetch_array($sql_term);

$sql_program = mysqli_query("SELECT * FROM programs WHERE id = $_POST[PROGRAM] ") or die(mysqli_error());
$program = mysqli_fetch_array($sql_program);
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
<span centered><br><b>Total Enrolled Students per Program</b></span>
<br><br>
<span tenpercent>
<?php
print "
	<br>
	<b>School Year:</b> $term[syear] $term[sem] <br>
	<b>Program:</b> $program[abbreviation] <br><br>
</span>
	<table class='report-table1'>
	<tr head>
		<td width='100px'></td>
		<td>Surname</td>
		<td>Given Name</td>
		<td>Year of Entry</td>
	</tr>
	<tr bgcolor='#ffc0c0'>
		<td><b>Female</b></td>
		<td colspan='3'></td>
	</tr>";
		
		$sql_FEMALE = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN studentstbl ON studentssubjtbl.studentid = studentstbl.idno WHERE term = '$TERM' AND program = '$_POST[PROGRAM]' AND sex = 'Female' GROUP BY studentssubjtbl.studentid ORDER BY lname ") or die(mysqli_error());
		if(mysqli_num_rows($sql_FEMALE) > 0) {
			$female_num = 0;
			while($Female = mysqli_fetch_array($sql_FEMALE)) {
			
			print "<tr>
						<td align='center'>".($female_num + 1)."</td>
						<td>$Female[lname]</td>
						<td>$Female[gname]</td>
						<td>$Female[yearofadmission]</td>
					</tr>";
				$female_num++;
			}
		}
	print "<tr bgcolor='#a3d5ff'>
			<td><b>Male</b></td>
			<td colspan='3'></td>
			</tr>";
		$sql_MALE = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN studentstbl ON studentssubjtbl.studentid = studentstbl.idno WHERE term = '$TERM' AND program = '$_POST[PROGRAM]' AND sex = 'Male' GROUP BY studentssubjtbl.studentid ORDER BY lname ") or die(mysqli_error());
		if(mysqli_num_rows($sql_MALE) > 0) {
			$male_num = 0;
			while($Male = mysqli_fetch_array($sql_MALE)) {
			print "<tr>
						<td align='center'>".($male_num + 1)."</td>
						<td>$Male[lname]</td>
						<td>$Male[gname]</td>
						<td>$Male[yearofadmission]</td>
					</tr>";
				$male_num++;
			}
		}
$TOTAL = $female_num + $male_num;
echo "</table>
		<br>
		<span tenpercent><b>TOTAL: $TOTAL</b>
		<br><br>
		";
?>
</body>
</html>