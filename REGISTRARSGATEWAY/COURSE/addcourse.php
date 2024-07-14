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
<a class='spanhead'>Add Course</a>
<a href='index.php' class='back' title='Cancel adding of course' >&#8629 Back to Courses</a>
</span>
<br>
<center>
<?php
if(isset($_POST['courseadd']))
{
	$coursecode=mysqli_real_escape_string($_POST['coursecode']);
	$coursedesc=mysqli_real_escape_string($_POST['coursedesc']);
	$section=mysqli_real_escape_string($_POST['section']);
	$lec=mysqli_real_escape_string($_POST['lec']);
	$lab=mysqli_real_escape_string($_POST['lab']);
	$labtype=mysqli_real_escape_string($_POST['labtype']);
	$slot=mysqli_real_escape_string($_POST['slots']);

	$coursez=mysqli_query("SELECT * FROM coursetbl where coursecode='$coursecode' and section='$section'") or die(mysqli_error());
	$count=mysqli_num_rows($coursez);

	
	
	if($count==1)
		{
			echo"COURSE IS ALREADY EXIST IN THIS SECTION";
		}
	else
		{
			$query=mysqli_query("INSERT INTO coursetbl (coursecode,coursedesc,section,nolec,nolab,labtype,slots) values ('$coursecode','$coursedesc','$section',$lec,$lab,'$labtype','$slot')") or die(mysqli_error());
			echo'<script type="text/javascript">alert("COURSE SUCCESSFULY ADDED");</script>';
		}
}
?>
	<form method=post id=addcourse>
	<table class='fillup-simple1'>
		<tr>
			<td>Course Code <br> 
				<input type="text" name="coursecode" required>
			</td>
			<td>Course Description <br>
				<input type="text" name="coursedesc" required>
			</td>
		</tr>
		<tr>
			<td>Section <br>
				<input type="text" name="section" required>
			</td>
			<td>No.Lecture <br>
				<input type="number" name="lec" required>
			</td>
		</tr>
		<tr>
			<td>No.Lab <br>
				<input type="number" name="lab" required>
			</td>
			<td>Lab Type <br>
				<select name=labtype>
						<option value="_ /_">-/-</option>
						<option value="AVR">AVR</option>
						<option value="Cisco Room">Cisco Room</option>
						<option value="Physics Lab Room">Physics Lab Room</option>
						<option value="Chem Lab Room">Chem Lab Room</option>
						<option value="Bio Lab Room">Bio Lab Room</option>
						<option value="Others">Others</option>
					</select>
			</td>
		</tr>	
		<tr>
			<td>Slots <br>
				<input type="number" name="slots" required>
			</td>
			<td></td>
			</tr>
			<tr>
				<td colspan='2'> <br>
					<input type=submit name=courseadd form=addcourse value='Submit' class='button'>
					<span label>** Warning!!</font>be sure to follow the format indicated opposite the field or ERROR will result in submission **</span>
				</td>
			</tr>
	</table>
	</form>

</div>
</div>
</body>
</html>