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
require "../../frame-css.txt"; 
require "../../list-table-css.txt";
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
header('location:../../index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:../../chooseterm.php');
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
<a class='spanhead'>Classroom Schedules</a>
<a href='../index.php' class='back'>&#8629 Back to Reports</a>
</span>
<br>
<br>
<center>

	<div style="float:left;margin-left:200px;">
	<form method=POST action="index_2.php">
		<table>
			<tr>
				<td>School Year :</td>
				<td><select name=year>
					<?php
						$sem=mysqli_query("SELECT * FROM semtbl group by syear");
						while($semf=mysqli_fetch_array($sem))
						{
							echo"<option value=".$semf['syear'].">".$semf['syear']."</option>";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Sem :</td>
				<td><select name=sem>
				<option value=1st>1st</option>
				<option value=2nd>2nd</option>
				<option value=summer>Summer</option>
				</select>
				</td>
			</tr>
			<tr>
			<td colspan=2><input type=submit name=submit value=GO></td>
			</tr>
		</table>
		</form>
		<br>
	</div>
</div>
</div>
</body>
</html>