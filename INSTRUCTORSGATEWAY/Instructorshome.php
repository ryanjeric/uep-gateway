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
if (!isset($_SESSION['id4'])){
header('location:index.php');
}
if(!isset($_SESSION['sem1']))
{
header('location:chooseterm.php');
}
?>
<?php
$idno=$_SESSION['id4'];
$sem=$_SESSION['sem1'];
$res=mysqli_query("SELECT * FROM staff where ctr=$idno") or die(mysqli_error());
$row=mysqli_fetch_array($res);
    $LNAME        = $row['lname'];
    $GNAME        = $row['gname'];
    $empid        = $row['empid'];
    $designation  = $row['designation'];
    $datehired    = $row['datehired'];
$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
$rows=mysqli_fetch_array($ress);
?>
<div warp>
<?php include "info.php";?>

<div d2>

<?php require "Instructors-navigation.php"; ?>

<div d4>
<?php 
print "<table info>
    <tr class='head'>
        <td colspan='2' head>WELCOME TO YOUR PORTAL</td>
    </tr>
    <tr>
        <td>EMPLOYEE ID</td>
        <td>$empid</td>
    </tr>
    <tr>
        <td>Last Name</td>
        <td>$LNAME</td>
    </tr>
    <tr>
        <td>Given Name</td>
        <td>$GNAME</td>
    </tr>
    <tr>
        <td>Designation</td>
        <td>$designation</td>
    </tr>
    <tr>
        <td>Date hired</td>
        <td>$datehired</td>
    </tr>
</table>";
?>
</div>
</div>

</div>
</body>

</html>