<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Students's Gateway</title>
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
if (!isset($_SESSION['id3'])){
header('location:index.php');
}
if(!isset($_SESSION['sem2']))
{
header('location:chooseterm.php');
}
?>
<?php
$idno=$_SESSION['id3'];
$sem=$_SESSION['sem2'];
$res=mysqli_query("SELECT * FROM studentstbl LEFT JOIN programs ON studentstbl.program = programs.id where idno=$idno ") or die(mysqli_error());
$row=mysqli_fetch_array($res);
    $LNAME = $row['lname'];
    $GNAME = $row['gname'];
    $PROGRAM = $row['abbreviation'];
    $EMAIL = $row['email'];
$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
$rows=mysqli_fetch_array($ress);
?>
<div warp>
<?php include "info.php";?>

<div d2>

<?php require "student-navigation.php"; ?>

<div d4>
<?php 
print "<table info>
    <tr class='head'>
        <td colspan='2' head>WELCOME TO YOUR PORTAL</td>
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
        <td>Program</td>
        <td>$PROGRAM</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>$EMAIL</td>
    </tr>
</table>";
?>
</div>
</div>

</div>
</body>

</html>