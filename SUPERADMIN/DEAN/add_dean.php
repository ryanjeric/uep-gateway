<?php
ob_start();
session_start();
include('conn.php');

if (!isset($_SESSION['super_id'])){
header('location:../index.php');
}
if(!isset($_SESSION['super_sem']))
{
header('location:../chooseterm.php');
}

$date = date("Y-m-d H:i:s A");
?>
<!DOCTYPE html>
<html>
<head>
<title>UEP - SUPERADMIN</title>
<style>
<?php 
require "../frame-css.txt";
require "../fillup-table-css.txt";
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
$id=$_SESSION['super_id'];
$sem=$_SESSION['super_sem'];
$res=mysqli_query("SELECT * FROM superadmin where superadmin_empid=$id") or die(mysqli_error());
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
<a class='spanhead'>New Dean</a>
<a href='index.php' class='back' title='Cancel adding of Dean' >&#8629 Back</a>
</span>
<br>
<center>
<?php
if(isset($_POST['staffadd']))
{
	$lname=mysqli_real_escape_string(ucwords(strtolower($_POST['lname'])));
	$fname=mysqli_real_escape_string(ucwords(strtolower($_POST['fname'])));
	$mname=mysqli_real_escape_string(ucwords(strtolower($_POST['mname'])));
	$empid=mysqli_real_escape_string($_POST['empid']);
	$dept=mysqli_real_escape_string(strtoupper($_POST['department']));
	$datehired=mysqli_real_escape_string($_POST['datehired']);
	
	$staffz=mysqli_query("SELECT * FROM user where empid='$empid' ") or die(mysqli_error());
	$count=mysqli_num_rows($staffz);

	if($count==1)
		{
			echo"EMPLOYEE ID ALREADY EXIST";
		}
	else
		{
			$query=mysqli_query("INSERT INTO user VALUES ('','$fname','$mname','$lname','$empid','password','$dept','DEAN','$datehired','ACTIVATED')") or die(mysqli_error());
			echo'<script type="text/javascript">alert("DEAN SUCCESSFULY ADDED");</script>';
		}
}
?>
	<form method=post id='addstaff'>
	<table class='fillup-simple1' >
			<tr>
				<td>Employee ID<br>
					<input type="text" name="empid" required>
				</td>
				<td>
					Department<br>
					<input type=text name="department" required>
				</td>
			</tr>
			<tr>
				<td>First Name <br>
					<input type=text name="fname" required>
				</td>
				<td>Middle Name <br>
					<input type=text name="mname" required>
				</td>
			</tr>
			<tr>
				<td>Last Name <br>
					<input type=text name="lname" required>
				</td>
				<td>Date Hired <br>
					<input type='text' name="datehired" required placeholder="MM/DD/YYYY">
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