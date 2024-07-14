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
<span centered><br><b>Total Enrolled Students per Program</b></span>
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
	<b>Course:</b> <select name='PROGRAM' id='program' style='margin-right:3%' required>
	<option>Select:</option>
		<?php
			$sql_PROG = mysqli_query("SELECT * FROM programs ORDER BY abbreviation") or die(mysqli_error());
			if(mysqli_num_rows($sql_PROG) > 0) {
				while($PROG = mysqli_fetch_array($sql_PROG)) {
					echo "<option value='$PROG[id]'>$PROG[abbreviation]</option>";
				}
			}
		?>
	</select>
	<input type='submit' name='GO' value='GO'>
	</form>
</span>
<br><br>
<?php
if(isset($_POST['GO'])) {
print "<table class='report-table1'>
	<tr head>
		<td width='100px'></td>
		<td>Surname</td>
		<td>Given Name</td>
		<td>Year of Entry</td>
	</tr>
	<tr bgcolor='#ffc0c0'>
		<td><b>Female</b></td>
		<td colspan='3'></td>
	</tr>";
	
		$sql_term = mysqli_query("SELECT * FROM semtbl WHERE syear = '$_POST[SY]' AND sem = '$_POST[SEM]' ") or die(mysqli_error());
		$TERM = mysqli_fetch_array($sql_term)['id'];
		$PROGRAM = $_POST['PROGRAM'];

		$sql_FEMALE = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN studentstbl ON studentssubjtbl.studentid = studentstbl.idno WHERE term = '$TERM' AND program = '$_POST[PROGRAM]' AND sex = 'Female' GROUP BY studentssubjtbl.studentid ORDER BY lname ") or die(mysqli_error());
		if(mysqli_num_rows($sql_FEMALE) > 0) {
			$female_num = 0;
			while($Female = mysqli_fetch_array($sql_FEMALE)) {
			
			print "<tr>
						<td align='center'>".($female_num + 1)."</td>
						<td>$Female[lname]</td>
						<td>$Female[gname]</td>
						<td>$Female[yearofadmission]</td>
					</tr>";
				$female_num++;
			}
		}
	print "<tr bgcolor='#a3d5ff'>
			<td><b>Male</b></td>
			<td colspan='3'></td>
			</tr>";
		$sql_MALE = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN studentstbl ON studentssubjtbl.studentid = studentstbl.idno WHERE term = '$TERM' AND program = '$_POST[PROGRAM]' AND sex = 'Male' GROUP BY studentssubjtbl.studentid ORDER BY lname ") or die(mysqli_error());
		if(mysqli_num_rows($sql_MALE) > 0) {
			$male_num = 0;
			while($Male = mysqli_fetch_array($sql_MALE)) {
			print "<tr>
						<td align='center'>".($male_num + 1)."</td>
						<td>$Male[lname]</td>
						<td>$Male[gname]</td>
						<td>$Male[yearofadmission]</td>
					</tr>";
				$male_num++;
			}
		}
$TOTAL = $female_num + $male_num;
echo "</table>
		<br>
		<span tenpercent><b>TOTAL: $TOTAL</b>
		<br><br>
		<form action='d_print.php' target='_blank' method='POST'>
			<input type='hidden' name='TERM' value='$TERM'>
			<input type='hidden' name='PROGRAM' value='$PROGRAM'>
			<input type='submit' value='Print' style='float:left;'>
		</form>
		<form action='../registrarshome.php' method='POST'>
			<input type='submit' value='Home'>

		</form>
		</span>
		<br><br>
		";
?>
	<script>
		$(document).ready(function() {
			var SY = "<?php echo $_POST[SY];?>";
			var SEM = "<?php echo $_POST[SEM];?>";
			var PROGRAM = "<?php echo $_POST[PROGRAM];?>";
			$("#sy option[value='"+SY+"']").prop('selected', true);
			$("#sem option[value='"+SEM+"']").prop('selected', true);
			$("#program option[value='"+PROGRAM+"']").prop('selected', true);
		});
	</script>
<?php
}
?>
</div>
</div>
</body>
</html>