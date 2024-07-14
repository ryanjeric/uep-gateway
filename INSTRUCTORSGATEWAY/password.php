<?php
error_reporting(0);
ob_start();
include('conn.php');
session_start();
$grading = 'MIDTERM';
?>
<!DOCTYPE html>
<html>
<head>
<title>Instructor's Gateway</title>
<style>
<?php 
require "frame-css.txt"; 
require "list-table-css.txt";
require "table-css.txt";
require "fillup-table-css.txt";
?>
input[type='submit'],[sub]{
    height:30px;
    width:180px;
    cursor:pointer;
    font-size:90%;
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
<script src="jquery.js"></script>
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
$sem=$_SESSION['sem'];
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
<a class='spanhead'>Change Password</a>
<a href='instructorshome.php' class='back' title='Cancel Changing of Password' >&#8629 Back</a>
</span>
<br>
<?php
if(isset($_POST['change']))
{
    $OLD = $_POST['oldpassword'];
    $OLD = mysqli_real_escape_string(strtolower($OLD));
    $NEW = $_POST['newpassword'];
    $CONFIRM = $_POST['confirmpassword'];

    $sql = mysqli_query("SELECT * FROM staff WHERE ctr = '$id' ")  or die(mysqli_error());
    $password = mysqli_fetch_array($sql)['password'];
    $password = mysqli_real_escape_string(strtolower($password));

    if($OLD == $password) {
        if($NEW == $CONFIRM) {
            if($OLD <> $NEW) {
                $SQL = mysqli_query("UPDATE staff SET password = '$NEW' WHERE ctr = '$id' ") or die(mysqli_error());
                echo "<script>alert('Password Successfully Changed.')</script>";
            }
            else {
                echo "<script>alert('No Changes had been made.')</script>";
            }
        }
        else {
            echo "<script>alert('WARNING! NEW PASSWORD didn\'t match perfectly.')</script>";
        }
    }
    else {
        echo "<script>alert('WARNING! OLD PASSWORD is incorrect')</script>";
    }

}
?>
    <form method='POST'>
    <table class='fillup-simple1' >
            <tr>
                <td>Old Password<br>
                    <input type="password" name="oldpassword" required>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>New Password <br>
                    <input type='password' name="newpassword" required>
                </td>
                <td>Confirm New Password<br>
                    <input type='password' name="confirmpassword" required>
                </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <br><input type='submit' name='change' value='Change' class='button'>
                </td>
            </tr>
    </table>
    </form>
</div>
</div>
</body>
</html>