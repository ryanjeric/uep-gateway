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
require "../frame-css.txt"; 
require "../list-table-css.txt";
?>
[reports-button]:hover {
filter:invert(80%);
-webkit-filter:invert(90%);
}
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
<?php
include "info.php";
?>

<div d2>
<span class='divhead'>
<a class='spanhead'>REPORTS</a>
<a href='../registrarshome.php' class='back'>&#8629 Back to Home</a>
</span>
<br>
<br>
<center>

	<a href='scheduleofclasses' style="background:#fff url('icons/a-schedule_of_classes.png') no-repeat 0 0;" reports-button></a>
	<a href='listofprograms' style="background:#fff url('icons/b-list_of_academic_programs.png') no-repeat 0 0;" reports-button></a>
	<a href='totalenrolledstudents' style="background:#fff url('icons/c-total_enrolled_students.png') no-repeat 0 0;" reports-button></a>
	<a href='d.php' style="background:#fff url('icons/d-total_enrolled_students_per_program.png') no-repeat 0 0;" reports-button></a>
	<br>
	<a href='e.php' style="background:#fff url('icons/e-grades_of_a_student.png') no-repeat 0 0;" reports-button></a>
	<a href='f.php' style="background:#fff url('icons/f-faculty_grades.png') no-repeat 0 0;" reports-button></a>
	<a href='g.php' style="background:#fff url('icons/g-subject_offerings.png') no-repeat 0 0;" reports-button></a>
	<a href='h.php' style="background:#fff url('icons/h-changed_grades.png') no-repeat 0 0;" reports-button></a>
</center>
<br><br>
</div>
</div>
</body>
</html>