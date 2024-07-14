<?php
error_reporting(0);
ob_start();
include('../conn.php');
session_start();
$staff_ID = $_POST['staff_ID'];
$SEM = $_POST['SEM'];

$sql_staff = mysqli_query("SELECT * FROM staff WHERE ctr = '$staff_ID' ") or die(mysqli_error());
$staff = mysqli_fetch_array($sql_staff);

$sql_sem = mysqli_query("SELECT * FROM semtbl WHERE id = '$SEM' ") or die(mysqli_error());
$sem_SY = mysqli_fetch_array($sql_sem);
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
<center>
<h2>Faculty Schedule</h2>
</center>

<span tenpercent>
	<b>Instructor:</b> <?php echo $staff['lname'] . ", $staff[gname]"; ?> <br>
	<b>School Year:</b> <?php echo $sem_SY['syear'] . " $sem_SY[sem]"; ?>
</span><br><br>
<table class='report-table1'>
	<tr head>
		<td></td>
		<td>Subj Code</td>
		<td>Subj Description</td>
		<td>Section</td>
		<td>Units</td>
		<td>Schedule</td>
		<td>No of Enrolled</td>
	</tr>
	<?php
	$sql = mysqli_query("SELECT * FROM schedule LEFT JOIN  coursetbl ON schedule.courseid = coursetbl.id WHERE term = '$SEM' AND instructor = '$staff_ID' GROUP BY courseid ") or die(mysqli_error());
	$rounds = 1;
	while($data = mysqli_fetch_array($sql)) {
		$TERM = $data['term'];
		$COURSE = $data['courseid'];
	
		print "<tr>
					<td>".$rounds++."</td>
					<td>$data[coursecode]</td>
					<td>$data[coursedesc]</td>
					<td>$data[section]</td>
					<td>";
						if($data['nolab'] > 0) {echo "$data[nolec]/$data[nolab]";}
						else{echo"$data[nolec]";}

		print "		</td>
					<td>";
						$SQL = mysqli_query("SELECT * FROM schedule WHERE term = '$SEM' AND courseid = '$COURSE' AND instructor = '$staff_ID' ORDER BY classtype DESC ") or die(mysqli_error());
						while($DATA = mysqli_fetch_array($SQL)) {
							echo "<b>".$DATA['classtype']."</b> ";
							if($DATA['m']==1){echo'M';}
							if($DATA['t']==1){echo'T';}
							if($DATA['w']==1){echo'W';}
							if($DATA['th']==1){echo'TH';}
							if($DATA['f']==1){echo'F';}
							if($DATA['s']==1){echo'S';}
							
							if($DATA["startmin"] == 0) { $startmin = "00";}
                            else {$startmin = $DATA["startmin"];}

                            if($DATA["endmin"] == 0) { $endmin = "00";}
                            else {$endmin = $DATA["endmin"];}

                            echo'|'.$DATA["starthr"].' : '.$startmin.' '.$DATA["starttypeday"].'
                            to '.$DATA["endhr"].' : '.$endmin.' '.$DATA["endtypeday"].' |';
						}
		print "		</td>
					<td>";
						$sql_noofstud = mysqli_query("SELECT * FROM studentssubjtbl WHERE term = '$SEM' AND courseid = '$COURSE' ") or die(mysqli_error());
						echo mysqli_num_rows($sql_noofstud);
		print "		</td>
			   </tr>";
	
	}
		print "</table><br>";
	?>
</table>
<br>
</div>
</div>
</body>
</html>