<?php
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
if (!isset($_SESSION['super_id'])){
header('location:../index.php');
}
if(!isset($_SESSION['super_sem']))
{
header('location:../chooseterm.php');
}
?>
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
<a class='spanhead'>Add Registrar</a>
<a href='index.php' class='back' title='Cancel adding of staff' >&#8629 Back to Registrar</a>
</span>
<br>
<center>
<?php
if(isset($_POST['staffadd']))
{
	$lname=mysqli_real_escape_string(ucwords(strtolower($_POST['lname'])));
	$gname=mysqli_real_escape_string(ucwords(strtolower($_POST['gname'])));
	$empid=mysqli_real_escape_string($_POST['empid']);
	$des=mysqli_real_escape_string($_POST['designation']);
	$datehired=mysqli_real_escape_string($_POST['datehired']);
	
$staffz=mysqli_query("SELECT * FROM registrar where empid='$empid'") or die(mysqli_error());
	$count=mysqli_num_rows($staffz);

	if($count==1)
		{
			echo"REGISTRAR IS ALREADY EXIST";
		}
	else
		{
			$query=mysqli_query("INSERT INTO registrar(lname,gname,empid,designation,datehired,password,status) values ('$lname','$gname','$empid','$des','$datehired','password','ACTIVATE')") or die(mysqli_error());
			echo'<script type="text/javascript">alert("STAFF SUCCESSFULY ADDED");</script>';
		}
}
?>
	<form method=post id='addstaff'>
	<table class='fillup-simple1'>
		<tr>
			<td>Employee ID <br>
				<input type="text" name="empid" required>
			</td>
			<td>Designaion <br>
				<select name="designation" required>
					<option value="">-SELECT-</option>
					<option value="REGISTRAR">REGISTRAR</option>
					<option value="ASSISTANT CLERK">ASSISTANT CLERK</option>
				</select>
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
			<td>Date Hired <br>
				<input type=date name="datehired" placeholder='MM/DD/YYYY'>
			</td>
			<td></td>
		</tr>
		<tr>
			<td colspan='2'> <br>	
			<input type=submit name=staffadd form=addstaff value='POST' class='button'>
			<span label>** Warning!!</font>be sure to follow the format indicated opposite the field or ERROR will result in submission **</span>
			</td>
		</tr>
	</table>
	</form>

</div>
</div>
</body>
</html>