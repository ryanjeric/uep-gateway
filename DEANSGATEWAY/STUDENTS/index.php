<?php
error_reporting(0);
ob_start();
include('conn.php');
session_start();
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
<script>
<?php
	require "js-time.txt";
?>
</script>
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
<div warp>
	<?php include "info.php"; ?>
<div d2>
<span class='divhead'>
<a class='spanhead'>Students Information</a>
<a href='../deanshome.php' class='back' title='HOME' >&#8629 Back to Home</a>
</span>
<br>
<br>
<center>
	<?php
	$students=mysqli_query("SELECT * FROM studentstbl LEFT JOIN programs ON studentstbl.program = programs.id WHERE idno LIKE '%$_POST[search]%' OR (gname LIKE '%$_POST[search]%' OR lname LIKE '%$_POST[search]%') ORDER BY lname ") or die(mysqli_error());
	$studentsnumber=mysqli_num_rows($students);
	$count = 1;
	echo"<form method='POST'>
	<table class='list4' width='90%'>
		<tr head>
			<td colspan='3'>No. of Students : $studentsnumber </td>
			<td colspan='4' align=right> Search Student Name/ID no : <input type=text name='search' search><input type='submit' name='btn_search' value='Search'/></td>
		</tr>
		<tr head>
			<td width=80px>Count</td>
			<td width=150px>ID No.</td>
			<td width=200px>Last Name</td>
			<td width=200px>Given Name</td>
			<td width=100px>Status</td>
			<td width=100px>Program</td>
			<td>Action</td>
		</tr>
		</table></form>";

	echo "<div style='max-height:300px; width:90%; overflow:scroll;'>
		<table class='list4' width='100%'>";
		while($data=mysqli_fetch_array($students))
		{
			if($data['status'] == 1) { $STATUS = 'Active';} else { $STATUS = 'Inactive';}
		echo'
			<tr>
				<td width=80px>'. $count++ .'</td>
				<td width=150px>'.$data["idno"].'</td>
				<td width=200px>'.$data["lname"].'</td>
				<td width=200px>'.$data["gname"].'</td>
				<td width=100px>'.$STATUS.'</td>
				<td width=100px>'.$data["abbreviation"].'</td>
				<td><a href="details.php?idno='.$data['idno'].'" style="float:left;" buttonlike>Profile</a>';

				$studid=$data["idno"];
				$studquery=mysqli_query("SELECT * FROM studentssubjtbl where term=$sem and studentid=$studid") or die(mysqli_error());
				$check=mysqli_num_rows($studquery);
				if ($check==0) {
					echo'<form method=POST action="addsubject.php">
					<input type=hidden value='.$studid.' name=studid>
					<input type=submit name="add" value="Add Subjects">
					</form>';
				}
				else {
					echo'<form method=POST action="StudentsSubject.php?id='.$studid.'">
					<input type=hidden value='.$studid.' name=studid>
					<input type=submit name="viewsubj" value="View Subject">
					</form>';
				}
					
			echo'</td></tr>';
		}
		?>
	</table></div><br>
</div>
</div>
</body>
</html>
<?php
if(isset($_POST['btn_search'])) {
	$search = $_POST['search'];
	?>
	<script>
		$(document).ready(function() {
			$('input[search]').val('<?php echo $search;?>');
		});
	</script>
	<?php
}
?>