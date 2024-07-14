<?php
error_reporting(0);
ob_start();
include('conn.php');
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
	require "js-time.txt";
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
<div warp>
	<?php include "info.php"; ?>
<div d2>
<span class='divhead'>
<a class='spanhead'>Students Information</a>
<a href='../registrarshome.php' class='back' title='Cancel adding of course' >&#8629 Back to Home</a>
</span>
<br>
<br>
<center>
	<?php
	$students=mysqli_query("SELECT * FROM studentstbl LEFT JOIN programs ON studentstbl.program = programs.id WHERE idno LIKE '%$_POST[search]%' OR (gname LIKE '%$_POST[search]%' OR lname LIKE '%$_POST[search]%') ORDER BY lname ") or die(mysqli_error());
	$studentsnumber=mysqli_num_rows($students);
	$count = 1;

	echo"<form method='POST'><table class='list2'>
		<tr>
			<td colspan='7'><a href='addstudent.php' class='new-or-add'>+Add New Student</a></td>
		</tr>
		<tr>
			<td colspan='5'>No. of Students : $studentsnumber</td>
			<td colspan='2' style='text-align:right'>Search: <input type='text' name='search' search>
			<input type='submit' name='btn_search' value='Search' />
			</td>
		</tr>
		<tr head>
			<th width=80px>Count</th>
			<th width=150px>ID No.</th>
			<th width=200px>Last Name</th>
			<th width=200px>Given Name</th>
			<th width=100px>Status</th>
			<th width=100px>Program</th>
			<th>Action</th>
		</tr>
		</table></form>
		<div style='max-height:300px; width:90%; overflow:scroll;'>
		<table class='list4' width=100%>";
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
				<td><a href="details.php?idno='.$data['idno'].'" buttonlike>Details</a>
					<a href="sched.php?id='.$data['idno'].'" buttonlike>Sched</a>
			</td>
			</tr>';
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