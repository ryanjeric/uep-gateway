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
<span centered><br><b>Grades of a Student</b></span>
<br><br>
<form method='POST'>
<span tenpercent>
	<b>Student Number:</b> <input type='text' name='studentno' id='studentno' style='height:25px;padding-left:5px;' required>
	<input type='submit' name='GO' value='GO'/> <br>
	<br>
</span>
</form>
<?php
if(isset($_POST['GO'])) {
	$sql = mysqli_query("SELECT * FROM studentstbl LEFT JOIN programs ON studentstbl.program = programs.id WHERE idno = '$_POST[studentno]' ") or die(mysqli_error());
	if(mysqli_num_rows($sql) > 0) {
		$stud = mysqli_fetch_array($sql);
print "	<span tenpercent>
		<b>Student Number:</b> <u>$stud[idno]</u><br>
		<b>Name:</b> <u>$stud[lname], $stud[gname]</u><br>
		<b>Program:</b> <u>$stud[programdesc]</u>
		</span>
		<br><br>";
	}
	else {
		echo "<table class='report-table1'><tr head><td>No Record</td></tr></table>";
	}

	$SQL = mysqli_query("SELECT * FROM studentssubjtbl 
						LEFT JOIN semtbl ON studentssubjtbl.term = semtbl.id 
						LEFT JOIN coursetbl ON studentssubjtbl.courseid = coursetbl.id
						WHERE studentid = '$_POST[studentno]' ORDER BY term") or die(mysqli_error());
	if(mysqli_num_rows($SQL) > 0) {
		print "<table class='report-table1'>
				<tr head>
					<td width='100px'>SY</td>
					<td>Sem</td>
					<td>Subj Code</td>
					<td>Subj Description</td>
					<td>Section</td>
					<td>Units</td>
					<td>Grade</td>
				</tr>";
		$LEC_units = 0;
		$LAB_units = 0;
		while($data = mysqli_fetch_array($SQL)) {
			$rounds = 1;
			$TERM = $data['term'];
			$COURSE = $data['courseid'];
			$SID = $data['studentid'];
			$LEC_units = $LEC_units + $data['nolec'];
			$LAB_units = $LAB_units + $data['nolab'];

			if($key <> $TERM && $rounds <> 1) {
				echo "<tr><td colspan='7'></td></tr>";
			}
			print "<tr>
						<td>$data[syear]</td>
						<td>$data[sem]</td>
						<td>$data[coursecode]</td>
						<td>$data[coursedesc]</td>
						<td>$data[section]</td>
						<td>";
							if($data['nolab'] > 0) {echo "$data[nolec]/$data[nolab]";}
							else{echo"$data[nolec]";}
				print	"</td>
						<td>";
							$sel_prelimgrade = mysqli_query("SELECT * FROM prelimgrade WHERE term = $TERM AND courseid= $COURSE AND studentid = $SID");
						        $prelim = mysqli_fetch_array($sel_prelimgrade);
						            $prelim_grade = $prelim['grade_prelim'];
						            $COMPLY = $prelim['complied'];
						    $sel_midtermgrade = mysqli_query("SELECT * FROM midtermgrade WHERE term = $TERM AND courseid= $COURSE AND studentid = $SID");
						        $midterm_grade = mysqli_fetch_array($sel_midtermgrade)['grade_midterm'];
						    $sel_prefinalgrade = mysqli_query("SELECT * FROM prefinalgrade WHERE term = $TERM AND courseid= $COURSE AND studentid = $SID");
						        $prefinal_grade = mysqli_fetch_array($sel_prefinalgrade)['grade_prefinal'];
						    $sel_finalgrade = mysqli_query("SELECT * FROM finalgrade WHERE term = $TERM AND courseid= $COURSE AND studentid = $SID");
						        $final_grade = mysqli_fetch_array($sel_finalgrade)['grade_final'];
						    $FINAL_GRADE = number_format((($prelim_grade+$midterm_grade+$prefinal_grade+$final_grade)/4),2);
						    if($FINAL_GRADE <= 74)      {$numerical_equivalent = '5.00';}
						    elseif ($FINAL_GRADE <= 76) {$numerical_equivalent = '3.00';}
						    elseif ($FINAL_GRADE <= 79) {$numerical_equivalent = '2.75';}
						    elseif ($FINAL_GRADE <= 82) {$numerical_equivalent = '2.50';}
						    elseif ($FINAL_GRADE <= 85) {$numerical_equivalent = '2.25';}
						    elseif ($FINAL_GRADE <= 88) {$numerical_equivalent = '2.00';}
						    elseif ($FINAL_GRADE <= 91) {$numerical_equivalent = '1.75';}
						    elseif ($FINAL_GRADE <= 94) {$numerical_equivalent = '1.50';}
						    elseif ($FINAL_GRADE <= 97) {$numerical_equivalent = '1.25';}
						    elseif ($FINAL_GRADE <= 100) {$numerical_equivalent = '1.00';}
						    
						    if($COMPLY == 'Yes') {
						       $sel_gradesheet = mysqli_query("SELECT * FROM gradesheet WHERE term = $TERM AND courseid= $COURSE AND studentid = $SID ");
						        $num_equiv = mysqli_fetch_array($sel_gradesheet)['grade'];
						        $numerical_equivalent =  $num_equiv;
						    }
						    echo $numerical_equivalent;
						    $key = $data['term'];
						    $rounds++; 
				print	"</td>
				   </tr>";
		}
		echo "</table><br>";
		echo "<span tenpercent>";
		echo "<b>No. of Classes:</b> ". mysqli_num_rows($SQL) .", <b>TOTAL LEC Units:</b> $LEC_units, <b>TOTAL LAB Units:</b> $LAB_units, ";
		echo "<b>TOTAL UNITS:</b> " . ($LEC_units + $LAB_units) ;
		print "
			<br><br>
			<form action='e_print.php' target='_blank' method='POST'>
				<input type='hidden' name='studentno' value='$_POST[studentno]'>
				<input type='submit' value='Print' style='float:left;'>
			</form>
			<form action='../deanshome.php' method='POST'>
				<input type='submit' value='Home'>
			</form>
			</span>";

	}
}
?>
<br><br>
</div>
</div>
</body>
</html>