<?php
session_start();
include('conn.php');
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
	require "fillup-table-css.txt";
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
		$PASSWORD = $row['password'];
	$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
	$rows=mysqli_fetch_array($ress);
?>
<div warp>
	<?php include "info.php"; ?>
<div d2>
<span class='divhead'>
<a class='spanhead'>Change Password</a>
<a href='studenthome.php' class='back' title='Cancel' >&#8629 Back</a>
</span>
<br>
<center>
<?php
if(isset($_POST['change']))
{
	$OLD = $_POST['oldpassword'];
	$OLD = mysqli_real_escape_string(strtolower($OLD));
	$NEW = $_POST['newpassword'];
	$CONFIRM = $_POST['confirmpassword'];

	$sql = mysqli_query("SELECT * FROM studentstbl WHERE idno = '$idno' ")  or die(mysqli_error());
	$password = mysqli_fetch_array($sql)['password'];
	$password = mysqli_real_escape_string(strtolower($password));

	if($OLD == $password) {
		if($NEW == $CONFIRM) {
			if($OLD <> $NEW) {
				$SQL = mysqli_query("UPDATE studentstbl SET password = '$NEW' WHERE idno = '$idno' ") or die(mysqli_error());
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