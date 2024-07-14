<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php 
require "frame-css.txt";
require "deanshome-css.txt";
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

</script>
<script src='jquery.js'></script>
</head>
<body onload="startTime()" onload="StartTimers();" onmousemove="ResetTimers();">
<?php
include('conn.php');
session_start();
if (!isset($_SESSION['id'])){
header('location:index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:chooseterm.php');
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
<?php include "info.php";?>

<div d2>

<?php require "deans-navigation.php"; ?>

<div d4>
<table info>
<tr><td colspan='2' head><center><h3>W E L C O M E</h3></center></td></tr>
<tr><td>Complete Name:</td><td><?php echo''.$row["lname"].' , '.$row["fname"].' &nbsp '.$row["mname"].'    '; ?></td></tr>
<tr><td>Employee Number:</td><td><?php echo''.$row["empid"].'' ?> </td></tr>
<tr><td>Department:</td><td><?php echo''.$row["department"].'' ?></td></tr>
<tr><td>Position:</td><td><?php echo''.$row["position"].'' ?></td></tr>
<tr><td>Year Term:</td><td><?php echo''.$rows["syear"].' '.$rows["sem"].'' ?></td></tr>
</table>
</div>
</div>


</div>
</body>

</html>