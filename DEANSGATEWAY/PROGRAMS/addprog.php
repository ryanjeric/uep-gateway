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
<a class='spanhead'>Add Program</a>
<a href='index.php' class='back' title='Cancel adding of program' >&#8629 Back to Programs</a>
</span>
<br>
<center>
<?php
if(isset($_POST['progadd']))
{
	$prog=mysqli_real_escape_string($_POST['progdesc']);
	$abb=mysqli_real_escape_string($_POST['abbrv']);

	$progz=mysqli_query("SELECT * FROM programs where programdesc='$prog'") or die(mysqli_error());
	$count=mysqli_num_rows($progz);

	
	
	if($count==1)
		{
			echo"PROGRAM IS ALREADY EXIST";
		}
	else
		{
			$query=mysqli_query("INSERT INTO programs(programdesc,abbreviation) values ('$prog','$abb')") or die(mysqli_error());
			echo'<script type="text/javascript">alert("PROGRAM SUCCESSFULY ADDED");</script>';
		}
}
?>
	<form method=post id=addprog>
	<table class='fillup-simple1'>
			<tr>
				<td>Program Description <br>
					<input type="text" name="progdesc" required> <br>
					<span label>Ex. "Bachelor of Science in Information Technology"</span>
				</td>
				<td>Abbreviation <br>
					<input type="text" name="abbrv" required> <br>
					<span label>Ex. "BSIT"</span>
				</td>
			</tr>
			<tr>
				<td colspan='2'> <br>
					<input type=submit name=progadd form=addprog value='Submit' class='button'>
					<span label>** Warning!!</font>be sure to follow the format indicated opposite the field or ERROR will result in submission **</span>
				</td>
			</tr>
	</table>
	</form>

</div>
</div>
</body>
</html>