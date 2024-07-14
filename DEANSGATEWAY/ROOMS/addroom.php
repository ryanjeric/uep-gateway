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
<a class='spanhead'>Add Room</a>
<a href='index.php' class='back' title='Cancel adding of room' >&#8629 Back to Rooms</a>
</span>
<br><br>
<center>
<?php
if(isset($_POST['roomadd']))
{
	$room=mysqli_real_escape_string($_POST['roomname']);
	$roomdesc=mysqli_real_escape_string($_POST['roomdesc']);
	$type=mysqli_real_escape_string($_POST['type']);
	$typeothers=mysqli_real_escape_string($_POST['typeothers']);
	$vent=mysqli_real_escape_string($_POST['vent']);
	$seat=mysqli_real_escape_string($_POST['seats']);
	$area=mysqli_real_escape_string($_POST['area']);
	$remarks=mysqli_real_escape_string($_POST['remarks']);

	$roomz=mysqli_query("SELECT * FROM roomstbl where roomname='$room'") or die(mysqli_error());
	$count=mysqli_num_rows($roomz);

	
	
	if($count==1)
		{
			echo"ROOM IS ALREADY EXIST";
		}
	else
		{
			$query=mysqli_query("INSERT INTO roomstbl(roomname,roomdesc,type,typeothers,ventilation,seatcap,area,postedby,remarks) values ('$room','$roomdesc','$type','$typeothers','$vent','$seat','$area','".$row['lname']."','$remarks')") or die(mysqli_error());
			echo'<script type="text/javascript">alert("ROOM SUCCESSFULY ADDED");</script>';
		}
}
?>
	<form method=post id='addroom'>
	<table class='fillup-simple1'>
			<tr>
				<td>Room Name <br>
					<input type="text" name="roomname" required> <br>
					<span label>this must be unique.Examples : BlueRoom,Room_A,AVR</span>
				</td>
				<td> Room Description <br>
					<textarea name="roomdesc"></textarea> 
				</td>
			</tr>
			<tr>
				<td>Type<br>
					<select name="type" required>
						<option value="">-SELECT-</option>
						<option value="Lecture Room">Lecture Room</option>
						<option value="Lab Room">Lab Room</option>
						<option value="AVR">AVR</option>
						<option value="Cisco Room">Cisco Room</option>
						<option value="Physics Lab Room">Physics Lab Room</option>
						<option value="Chem Lab Room">Chem Lab Room</option>
						<option value="Bio Lab Room">Bio Lab Room</option>
						<option value="Office">Office</option>
						<option value="MultiPurpose Room">MultiPurpose Room</option>
						<option value="Library">Library</option>
						<option value="Others">Others</option>
					</select> <br>
					<span label>if not listed ,pls. Select OTHERS and write TYPE in the next field &rarr;.</span>
				</td>
				<td>Type (Others)<br><input type='text' name="typeothers"></td>
			</tr>
			<tr>
				<td>Ventilation <br>
					<select name="vent" required>
					<option value="">-SELECT-</option>
					<option value="With AirCon">With AirCon</option>
					<option value="Without AirCon">Without AirCon</option>
					</select>
				</td>
				<td>Seating Capacity<br>
					<input type='number' name="seats" required> <br>
					<span label>Numbers only</span></td>
			</tr>
			<tr>
				<td>Total Flr area (sq.m) <br>
					<input type='number' name="area"><br>
					<span label>Numbers only</span>
				</td>
				<td>Remarks (optional) <br>
					<textarea name="remarks"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<br>
					<input type=submit name=roomadd form=addroom value='Submit' class='button'>
					<span label>***Warning!!</font>be sure to follow the format indicated opposite the field or ERROR will result in submission **
				</td>
			</tr>
	</table>
	</form>

</div>
</div>
</body>
</html>