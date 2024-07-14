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
require "frame-css.txt";
require "css.txt";
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
if (!isset($_SESSION['id2'])){
header('location:index.php');
}
if(!isset($_SESSION['sem3']))
{
header('location:chooseterm.php');
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
<?php include "info.php";?>

<div d2>

<?php require "registrar-navigation.php"; ?>

<div d4>
<table info>
<tr><td colspan='2' head>WELCOME TO YOUR PORTAL</td></tr>
<tr><td>Complete Name:</td><td><?php echo''.$row["lname"].' , '.$row["gname"].''; ?></td></tr>
<tr><td>Employee Number:</td><td><?php echo''.$row["empid"].'' ?> </td></tr>
<tr><td>Designation :</td><td><?php echo''.$row["designation"].'' ?></td></tr>
<tr><td>Year Term:</td><td><?php echo''.$rows["syear"].' '.$rows["sem"].'' ?></td></tr>
</table>
</div>
</div>


</div>
</body>

</html>