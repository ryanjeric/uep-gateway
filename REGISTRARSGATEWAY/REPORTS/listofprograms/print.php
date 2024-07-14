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
<br>

<br>
<center>
<h2>LIST OF ACADEMIC PROGRAMS</h2>
<br>
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

					echo"<tr><td colspan=3>NO.of PROGRAMS :".$prognumber."</td></tr></table><br>";
	?>

</div>
</div>
</body>
</html>