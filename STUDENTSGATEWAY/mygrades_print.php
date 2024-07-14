<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Student's Gateway</title>
<script src='jquery.min.js'></script>
<style>
<?php 
	require "frame-css.txt"; 
	require "list-table-css.txt";
?>
</style>
<script>
<?php
	require "js-time.txt";
?>
</script>
</head>
<body onload="startTime()">
<?php
if (!isset($_SESSION['id3'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem2']))
{
header('location:../chooseterm.php');
}
?>
<?php
	$idno=$_SESSION['id3'];
	$sem=$_SESSION['sem2'];
	$res=mysqli_query("SELECT * FROM studentstbl where idno=$idno") or die(mysqli_error());
	$row=mysqli_fetch_array($res);
	$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
	$rows=mysqli_fetch_array($ress);
?>
<br>
<center><h2>My Grades</h2>
	<b>School Year:</b> <?php echo $rows['syear'] . " $rows[sem]";?>
<br><br>
	<table class='list3'>
	<tr head>
		<td>Course Code</td>
		<td>Course Description</td>
		<td>Numerical Equivalent</td>
		<td>Remarks</td>
	</tr>
<?php  
$sql = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN coursetbl ON studentssubjtbl.courseid = coursetbl.id WHERE studentid = $idno AND term = $sem ") or die(mysqli_error());
if(mysqli_num_rows($sql) > 0) {
	while($data = mysqli_fetch_array($sql)) {
		$SQL_prelim = mysqli_query("SELECT * FROM prelimgrade WHERE term = $sem AND studentid = $idno AND courseid = $data[courseid] ") or die(mysqli_error());
			$prelim = mysqli_fetch_array($SQL_prelim);
            $prelim_grade = $prelim['grade_prelim'];
            $COMPLY = $prelim['complied'];
		$SQL_midterm = mysqli_query("SELECT * FROM midtermgrade WHERE term = $sem AND studentid = $idno AND courseid = $data[courseid] ") or die(mysqli_error());
			$midterm_grade = mysqli_fetch_array($SQL_midterm)['grade_midterm'];
		$SQL_prefinal = mysqli_query("SELECT * FROM prefinalgrade WHERE term = $sem AND studentid = $idno AND courseid = $data[courseid] ") or die(mysqli_error());
			$prefinal_grade = mysqli_fetch_array($SQL_prefinal)['grade_prefinal'];
		$SQL_final = mysqli_query("SELECT * FROM finalgrade WHERE term = $sem AND studentid = $idno AND courseid = $data[courseid] ") or die(mysqli_error());
			$final_grade = mysqli_fetch_array($SQL_final)['grade_final'];
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

    if($FINAL_GRADE > 75) { $remarks = 'Passed';}
    else { $remarks = 'Failed';}
    if($COMPLY == 'Yes') {
    	$sel_gradesheet = mysqli_query("SELECT * FROM gradesheet WHERE term = $sem AND courseid= $data[courseid] AND studentid = $idno ");
    	$num_equiv = mysqli_fetch_array($sel_gradesheet)['grade'];
        $numerical_equivalent =  $num_equiv;
    }
		print "<tr>
					<td>$data[coursecode]</td>
					<td>$data[coursedesc]</td>
					<td align='center'>$numerical_equivalent</td>
					<td>$remarks</td>
				</tr>";
	}
}
else {
	//IF STUDENT doesnt have any subject
	print "<tr>
				<td colspan='4'><br>You don't have any Grades to show<br>
				<br></td>
			</tr>";
}
?>
</table>
<br>
</center>
<br>
</div>
</div>
</body>
</html>