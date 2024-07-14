<?php
error_reporting(0);
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
<div warp>
	<?php include "info.php"; ?>
<div d2>
<span class='divhead'>
<a class='spanhead'>Reports</a>
<a href='index.php' class='back' title='Reports' >&#8629 Back to Reports</a>
</span>
<br>
<span centered><br><b>Changed Grades</b></span>
<br><br>
<form method='POST'>
<span tenpercent>
	<b>School Year:</b> <select name='SY' id='sy' style='margin-right:3%' required>
		<option>Select:</option>
		<?php
		$sql_SY = mysqli_query("SELECT * FROM semtbl GROUP BY syear ORDER BY id DESC") or die(mysqli_error());
		if(mysqli_num_rows($sql_SY) > 0) {
			while($SY = mysqli_fetch_array($sql_SY)) {
				echo "<option value='$SY[syear]'>$SY[syear]</option>";
			}
		}
		?>
	</select>
	<b>Sem:</b> <select name='SEM' id='sem' style='margin-right:3%' required>
		<option>Select:</option>
		<option value='1st'>1st semester</option>
		<option value='2nd'>2nd semester</option>
		<option value='summer'>Summer</option>
	</select>
	<input type='submit' name='GO' value='GO'>
	</form>
</span>
<br>
<?php
if(isset($_POST['GO'])) {

		$sql_term = mysqli_query("SELECT * FROM semtbl WHERE syear = '$_POST[SY]' AND sem = '$_POST[SEM]' ") or die(mysqli_error());
		$TERM = mysqli_fetch_array($sql_term)['id'];
		$COURSE = $_POST['COURSE'];

	$sql = mysqli_query("SELECT * FROM changegrade LEFT JOIN coursetbl ON changegrade.coursecode = coursetbl.coursecode WHERE sem = '$TERM' ORDER BY datechange DESC ") or die(mysqli_error());
	if(mysqli_num_rows($sql) > 0) {
		print "<table class='report-table1'>
				<tr head>
					<td></td>
					<td>OR#</td>
					<td>Course Code</td>
					<td>Course Description</td>
					<td>Date Changed</td>
				</tr>";
		$rounds = 1;
		while($data = mysqli_fetch_array($sql)) {
			print "<tr>
						<td>".$rounds++."</td>
						<td>$data[OR]</td>
						<td>$data[coursecode]</td>
						<td>$data[coursedesc]</td>
						<td>$data[datechange]</td>
					</tr>";
		}
		echo "</table><br>
		<span tenpercent>
		<form action='h_print.php' method='POST' target='_blank'>
			<input type='hidden' name='TERM' value='$sem'>
			<input type='hidden' name='COURSE' value='$COURSE'>
			<input type='submit' value='Print' style='float:left'/>
		</form>
		<form action='../registrarshome.php'>
			<input type='submit' value='Home'/>
		</form>
		</span>";
	}
	else {
		echo "<table class='report-table1'><tr head><td>No Record</td></tr></table>";
	}
		
?>
	<script>
		$(document).ready(function() {
			var SY = "<?php echo $_POST[SY];?>";
			var SEM = "<?php echo $_POST[SEM];?>";
			var COURSE = "<?php echo $_POST[COURSE];?>";
			$("#sy option[value='"+SY+"']").prop('selected', true);
			$("#sem option[value='"+SEM+"']").prop('selected', true);
			$("#course option[value='"+COURSE+"']").prop('selected', true);
		});
	</script>
<?php
}
?>
<br><br>
</div>
</div>
</body>
</html>