<?php
error_reporting(0);
ob_start();
include('../conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Registrar's Gateway</title>
<style>
<?php 
	require "../frame-css.txt"; 
	require "../list-table-css.txt";
?>
</style>
<script>
<?php
	require "../js-time.txt";
?>
</script>
<script src='../jquery.js'></script>
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
<br>
<span centered><br><b>Subject Offerings</b></span>
<br><br>
<?php
	$TERM = $_POST['TERM'];

	$sql = mysqli_query("SELECT * FROM schedule LEFT JOIN semtbl ON schedule.term = semtbl.id
						LEFT JOIN coursetbl ON schedule.courseid = coursetbl.id WHERE term = '$TERM' GROUP BY courseid ") or die(mysqli_error());
	if(mysqli_num_rows($sql) > 0) {
		print "<table class='report-table1'>
					<tr head>
						<td width='100px'>SY</td>
						<td>Sem</td>
						<td>Subj Code</td>
						<td>Subj Description</td>
						<td>Section</td>
						<td>Units</td>
					</tr>";
		while($data = mysqli_fetch_array($sql)) {
			print "	<tr>
						<td>$data[syear]</td>
						<td>$data[sem]</td>
						<td>$data[coursecode]</td>
						<td>$data[coursedesc]</td>
						<td>$data[section]</td>
						<td>";
							if($data['nolab'] > 0) {echo "$data[nolec]/$data[nolab]";}
							else{echo"$data[nolec]";}
				print "	</td>
					</tr>";
		}
		echo 	"</table>";
	}
	else {
		echo "<table class='report-table1'><tr head><td>No Record</td></tr></table><br>";
	}

?>
</body>
</html>