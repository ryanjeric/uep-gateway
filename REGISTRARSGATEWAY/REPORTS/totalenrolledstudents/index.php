<?php
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
if (!isset($_SESSION['id2'])){
header('location:../../index.php');
}
if(!isset($_SESSION['sem3']))
{
header('location:../../chooseterm.php');
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
<?php
include "info.php";
?>

<div d2>
<span class='divhead'>
<a class='spanhead'>Total Enrolled Students</a>
<a href='../index.php' class='back'>&#8629 Back to Reports</a>
</span>
<br>
<br>

	<form method=POST action="index_2.php">
		<span tenpercent>
			School Year :
				<select name=year style='margin-right:5%;'>
					<?php
						$sem=mysqli_query("SELECT * FROM semtbl group by syear");
						while($semf=mysqli_fetch_array($sem))
						{
							echo"<option value=".$semf['syear'].">".$semf['syear']."</option>";
						}
					?>
					</select>
				Sem :
				<select name=sem style='margin-right:5%;'>
				<option value=1st>1st</option>
				<option value=2nd>2nd</option>
				<option value=summer>Summer</option>
				</select>
			<input type=submit name=submit value=GO>
		</span>
		</form>
		<br><br>
	</div>
</div>
</div>
</body>
</html>