<?php
error_reporting(0);
ob_start();
include('../conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
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
	<?php include "info.php"; ?>
<div d2>
<span class='divhead'>
<a class='spanhead'>Reports</a>
<a href='index.php' class='back' title='HOME' >&#8629 Back to Reports</a>
</span>
<br>
<span centered><br><b>Subject Offerings</b></span>
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
</span>
</form>
<br>
<?php
if(isset($_POST['GO'])) {
	$sql_term = mysqli_query("SELECT * FROM semtbl WHERE syear = '$_POST[SY]' AND sem = '$_POST[SEM]' ") or die(mysqli_error());
		$TERM = mysqli_fetch_array($sql_term)['id'];

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
		echo 	"</table><br>
				<span tenpercent>
					<form action='g_print.php' target='_blank' method='POST'>
						<input type='hidden' name='TERM' value='$TERM'>
						<input type='submit' value='Print' style='float:left;'>
					</form>
					<form action='../deanshome.php' method='POST'>
						<input type='submit' value='Home'>
					</form>
				</span><br><br>";
	}
	else {
		echo "<table class='report-table1'><tr head><td>No Record</td></tr></table><br>";
	}
	?>
	<script>
		$(document).ready(function() {
			var SY = "<?php echo $_POST[SY];?>";
			var SEM = "<?php echo $_POST[SEM];?>";
			$("#sy option[value='"+SY+"']").prop('selected', true);
			$("#sem option[value='"+SEM+"']").prop('selected', true);
		});
	</script>
	<?php
}
?>
</div>
</div>
</body>
</html>