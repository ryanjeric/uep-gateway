<?php
ob_start();
include('conn.php');
session_start();

$stud_ID = $_GET['id'];
$course_ID = $_GET['course'];
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
<script src='../jquery.js'></script>
<script>
<?php require "js-time.txt";?>

$(document).ready(function() {
	$('#sel_grade').hide();
	$('#save').hide();

	$('#change').click(function() {
		var grade = $('#grade').val();
		$("#sel_grade option[value='"+grade+"']").prop("selected", true);

		$('#grade').hide();
		$('#change').hide();
		$('#sel_grade').show();
		$('#save').show();
		return false;
	});
});
</script>
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
<a class='spanhead'>Grade </a>
<a href='sched.php?id=<?php echo $stud_ID;?>' class='back' title='HOME' >&#8629 Back</a>
</span>
<br><br>
<?php
	$sql_stud = mysqli_query("SELECT * FROM studentstbl WHERE idno = $stud_ID ") or die(mysqli_Error());
	$stud = mysqli_fetch_array($sql_stud);

	$sql_course = mysqli_query("SELECT * FROM coursetbl WHERE id = $course_ID") or die(mysqli_Error());
	$course =  mysqli_fetch_array($sql_course);

	print "<table class='style-horizontal'>
				<tr head>
					<td>Student #</td>
					<td>Full Name</td>
					<td>Course</td>
				</tr>
				<tr>
					<td>$stud[idno]</td>
					<td>$stud[lname], $stud[gname]</td>
					<td>$course[coursedesc]</td>
				</tr>
			</table>
	<br>
	";
	$sid = $stud_ID;
    $sel_prelimgrade = mysqli_query("SELECT * FROM prelimgrade WHERE term = $sem AND courseid= $course_ID AND studentid = $sid");
        $prelim = mysqli_fetch_array($sel_prelimgrade);
            $prelim_grade = $prelim['grade_prelim'];
            $COMPLY = $prelim['complied'];
    $sel_midtermgrade = mysqli_query("SELECT * FROM midtermgrade WHERE term = $sem AND courseid= $course_ID AND studentid = $sid");
        $midterm_grade = mysqli_fetch_array($sel_midtermgrade)['grade_midterm'];
    $sel_prefinalgrade = mysqli_query("SELECT * FROM prefinalgrade WHERE term = $sem AND courseid= $course_ID AND studentid = $sid");
        $prefinal_grade = mysqli_fetch_array($sel_prefinalgrade)['grade_prefinal'];
    $sel_finalgrade = mysqli_query("SELECT * FROM finalgrade WHERE term = $sem AND courseid= $course_ID AND studentid = $sid");
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

    if($FINAL_GRADE > 75) { $remarks = 'Passed';}
    else { $remarks = 'Failed';}

    if($COMPLY == 'Yes') {
    	$sel_gradesheet = mysqli_query("SELECT * FROM gradesheet WHERE term = $sem AND courseid= $course_ID AND studentid = $sid ");
    	$num_equiv = mysqli_fetch_array($sel_gradesheet)['grade'];
        $numerical_equivalent =  $num_equiv;
    }
 print "
 	<center><form method='POST'>
 	For the following REMARKS only: OD, UD, NFE & INC
 	<br>
 	<span style='display:inline-block;background:maroon;width:250px;height:250px; color:white; padding:10px; border:3px solid white; box-shadow: 0 2px 5px black'>
	<h2>GRADE</h2> <hr>
	<br><br>
		<input type='text' name='grade' value='$numerical_equivalent' id='grade' style='font-size:30px; height:100px; width:100px; text-align:center' disabled/> 
		<select name='sel_grade' id='sel_grade' style='font-size:20px; height:100px; width:100px;'>
			<option value='OD'>OD</option>
			<option value='UD'>UD</option>
			<option value='NFE'>NFE</option>
			<option value='INC'>INC</option>
			<option value='Normal'>Normal</option>
		</select>
	<br>
	<br>	
	<input type='submit' name='change' value='Change' id='change' />
	<input type='submit' name='save' value='Save' id='save' />
	</span>
	</center></form>
 ";

?>
<br><br>
</div>
</div>
</body>
</html>
<?php
if(isset($_POST['save'])) {
	$check = mysqli_query("SELECT * FROM gradesheet WHERE term = $sem AND courseid= $course_ID AND studentid = $stud_ID ")or die(mysqli_error());
	if(mysqli_num_rows($check) > 0) {
		$gradesheet_ID = mysqli_fetch_array($check)['gradesheetid'];
		$new_GRADE = $_POST['sel_grade'];
		if($new_GRADE == 'Normal') {
			$update_PRELIM = mysqli_query("UPDATE prelimgrade SET complied = 'No' WHERE term = $sem AND courseid= $course_ID AND studentid = $stud_ID ") or die(mysqli_error());
			$sql_UPDATE = mysqli_query("UPDATE gradesheet SET grade = '$new_GRADE' WHERE gradesheetid = $gradesheet_ID") or die(mysqli_error());
			header("Location:check_grade.php?id=$stud_ID&course=$course_ID");
		}
		else {
			$update_PRELIM = mysqli_query("UPDATE prelimgrade SET complied = 'Yes' WHERE term = $sem AND courseid= $course_ID AND studentid = $stud_ID ") or die(mysqli_error());
			$sql_UPDATE = mysqli_query("UPDATE gradesheet SET grade = '$new_GRADE' WHERE gradesheetid = $gradesheet_ID") or die(mysqli_error());
			echo "<script>alert('Successfully Changed.')</script>";
			header("Location:check_grade.php?id=$stud_ID&course=$course_ID");
		}
	}
	else {
		$new_GRADE = $_POST['sel_grade'];
		if($new_GRADE == 'Normal') {

		}
		else {
			$update_PRELIM = mysqli_query("UPDATE prelimgrade SET complied = 'Yes' WHERE term = $sem AND courseid= $course_ID AND studentid = $stud_ID ") or die(mysqli_error());
		
			$sql_INSERT = mysqli_query("INSERT INTO gradesheet VALUES('',$sem,$course_ID,$stud_ID,'$new_GRADE') ") or die(mysqli_error());
			echo "<script>alert('Successfully Changed.')</script>";
			header("Location:check_grade.php?id=$stud_ID&course=$course_ID");
		}
	}
	

}
?>