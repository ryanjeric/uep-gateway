<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Instructor's Gateway</title>
<style>
<?php 
require "frame-css.txt"; 
require "list-table-css.txt";
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
if (!isset($_SESSION['id4'])){
header('location:index.php');
}
if(!isset($_SESSION['sem1']))
{
header('location:chooseterm.php');
}
?>
<?php
$id=$_SESSION['id4'];
$sem=$_SESSION['sem1'];
$res=mysqli_query("SELECT * FROM staff where ctr=$id") or die(mysqli_error());
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
    <a class='spanhead'>Grading Period</a>
    <a href='mysched.php' class='back'>&#8629 GO BACK</a>
    </span>
<br><br>
<?php
if(isset($_POST['goprelim'])) { header('Location:prelim.php'); }
if(isset($_POST['gomidterm'])) { header('Location:midterm.php'); }
if(isset($_POST['goprefinal'])) { header('Location:prefinal.php'); }
if(isset($_POST['gofinal'])) { header('Location:final.php'); }
if(isset($_POST['gradesheet'])) { header('Location:gradesheet.php'); }
?>
<style>
input {
    height:45px;
    width:180px;
    cursor:pointer;
    font-size:100%;
}

[gradesheet] {
    background:linear-gradient(#bf3a3a 10%,maroon);
    color:white;
    border-radius:20px;
    border:2px solid #333;
    transition:all ease .3s;
}
[gradesheet]:hover {
    -moz-transform:scale(1.05);
    transition:all ease .5s;
}
</style>
<form method='POST'>
    <center>
<input type='submit' name='goprelim' value='Prelim' /> 
<input type='submit' name='gomidterm' value='Midterm' /> 
<input type='submit' name='goprefinal' value='Pre-Final' />
<input type='submit' name='gofinal' value='Final' />  <br><br>
<input type='submit' name='gradesheet' value='GRADESHEET' gradesheet/>
    </center>
    <br>
</form>
</div>
</div>
</body>
</html>
