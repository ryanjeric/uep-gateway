<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php 
require "../frame-css.txt";
require "../fillup-table-css.txt";
error_reporting(0)
?>

</style>
<script>
function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML = h+":"+m+":"+s;
    var t = setTimeout(function(){startTime()},500);
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>

</head>
<body onload="startTime()">
<?php
include('conn.php');
session_start();
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
<?php
include "info.php";
?>
<div d2>
<span class='divhead'>
<a class='spanhead'>Add Staff</a>
<a href='index.php' class='back' title='Cancel adding of staff' >&#8629 Back to Staff</a>
</span>
<br>
<center>
<?php
if(isset($_POST['staffadd']))
{
	$lname=mysqli_real_escape_string(ucwords(strtolower($_POST['lname'])));
	$gname=mysqli_real_escape_string(ucwords(strtolower($_POST['gname'])));
	$empid=mysqli_real_escape_string($_POST['empid']);
	$des=mysqli_real_escape_string(strtoupper($_POST['designation']));
	$dept=mysqli_real_escape_string(strtoupper($_POST['department']));
	$datehired=mysqli_real_escape_string($_POST['datehired']);
	
	$staffz=mysqli_query("SELECT * FROM staff where empid='$empid'") or die(mysqli_error());
	$count=mysqli_num_rows($staffz);

	if($count==1)
		{
			echo"INSTRUCTOR IS ALREADY EXIST";
		}
	else
		{
			$query=mysqli_query("INSERT INTO staff(lname,gname,empid,designation,datehired,password,status,department) values ('$lname','$gname','$empid','$des','$datehired','password','ACTIVATE','$dept')") or die(mysqli_error());
			echo'<script type="text/javascript">alert("INSTRUCTOR SUCCESSFULY ADDED");</script>';
		}
}
?>
	<form method=post id=addstaff>
	<table class='fillup-simple1' >
			<tr>
				<td>Employee ID<br>
					<input type="text" name="empid" required>
				</td>
				<td>Designation<br>
					<input type=text name="designation" required>
				</td>
			</tr>
			<tr>
				<td>Last Name <br>
					<input type=text name="lname" required>
				</td>
				<td>Given Name <br>
					<input type=text name="gname" required>
				</td>
			</tr>
			<tr>
				<td>
					Department<br>
					<input type=text name="department" required>
				</td>
				<td>Date Hired <br>
					<input type=date name="datehired" required placeholder="MM/DD/YYYY">
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<br><input type=submit name=staffadd form=addstaff value='POST' class='button'>
					<span label>** Warning!!</font>be sure to follow the format indicated opposite the field or ERROR will result in submission **</span>
				</td>
			</tr>
	</table>
	</form>
</div>
</div>
</body>
</html>