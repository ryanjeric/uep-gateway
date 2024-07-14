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
<a class='spanhead'>LIST OF ACADEMIC PROGRAMS</a>
<a href='../index.php' class='back'>&#8629 Back</a>
</span>
<br>
<br>
<center>

	<div>
	<?php
				$prog=mysqli_query("SELECT * FROM programs order by id") or die(mysqli_error());


	$prognumber=mysqli_num_rows($prog);

	echo"<table class='report-table1'>
		<tr head>
			<td>Count</td>
			<td>Program</td>
			<td>Program Description</td>
		</tr>";
		$count=1;
		while($progs=mysqli_fetch_array($prog))
		{
					echo'
					<tr>
					<td>'.$count++.'</td>
					<td>'.$progs["abbreviation"].'</td>
					<td>'.$progs["programdesc"].'</td>
					</tr>';
					
		}

					echo"<tr><td colspan=3>NO.of PROGRAMS :".$prognumber."</td></tr>
					</table>
					</center><br>
					<span tenpercent>
					
					<a href='print.php' target=_blank buttonlike>PRINT</a>
					<a href='../index.php' buttonlike>REPORTS</a>
					</span><br><br>";
	?>

</div>
</div>
</body>
</html>