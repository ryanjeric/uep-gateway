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
<a class='spanhead'>Total Enrolled Students</a>
<a href='index.php' class='back'>&#8629 Back</a>
</span>
<br>
<br>
<center>

	<div>
	<?php
			if(isset($_POST['submit']))
			{
					$year=$_POST['year'];
					$semm=$_POST['sem'];

					$semyr=mysqli_query("SELECT * FROM semtbl where syear='$year' and sem='$semm'");
					$checksem=mysqli_num_rows($semyr);
					$semf=mysqli_fetch_array($semyr);
					if($checksem==0)
					{
						echo'<script type="text/javascript">alert("TERM NOT EXIST");</script>';
						echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
					}
					else
					{
					$semid=$semf['id'];
					echo'
					<table><tr><td>YEAR : '.$year.'</td></tr>
					<tr><td>SEM : '.$semm.'</td></tr>
					</table>
					';
					
					$rooms=mysqli_query("SELECT * FROM roomstbl");
					echo'<br><table class="report-table1">';
					$c=1;
					while($roomf=mysqli_fetch_array($rooms))
					{
						echo'<tr><td>'.$c++.'</td><td>'.$roomf['roomname'].'</td><td><form method=POST action=roomsched.php>
								<input type=hidden value="'.$roomf["ctr"].'" name=roomid>
								<input type=hidden value="'.$semid.'" name=semid>
								<input type="submit" value="SCHEDULE" title="SCHEDULE" name=submit></form></td></tr>';

					}
					echo'</table><br>';
					}

			}
			else
			{
				header("Location: index.php");
			}
	?>

</div>
</div>
</body>
</html>