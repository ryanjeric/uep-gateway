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
<?php require "indexcss.txt"; ?>
</style>
</head>
<body>
<div warp>

<br>
<div d2>
<?php 
if(isset($_SESSION['id4']))
{
header('location:chooseterm.php');
}
if(isset($_POST['submit'])){
$idno=mysqli_real_escape_string($_POST['idno']);
$Password=mysqli_real_escape_string($_POST['pass']);
	if($idno=="" and $Password=="")
	{
		echo'<script type="text/javascript">alert("All fields are required!");</script>';
		echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
	}
	else
	{
	$result=mysqli_query("SELECT * FROM staff where empid='$idno' and password='$Password' and status='ACTIVATE' LIMIT 1") or die(mysqli_error());
	$count=mysqli_num_rows($result);
	$row=mysqli_fetch_array($result);
	
	if ($count>0){
	session_start();
	$_SESSION['id4']=$row['ctr'];
	$id3=$row['empid'];
	$_SESSION['logged4']= TRUE;
	header('location:chooseterm.php');
	}
	else{
		echo("<span id='loginerror'>Warning: Username or Password is Incorrect!</span>");
		}
}
}
?>
<center>
<?php 
$usr=&$_POST['idno'];
$pas=&$_POST['pass'];
?>
<form method=POST>
<div id='fixleft'>
</div>
	<table id='tbl-login'>
	<tr>
		<td rowspan='5' class='leftside'>
		<a href='../'><img src='redstar.png' id='redstar' /></a>
		<br>
		<abbr uep>UEP</abbr> <br>
		UNIVERSITY of <Br>
		EASTERN PANGASINAN
		</td>
	</tr>
	
	<tr><td colspan='2'><h2>Instructor's LOG-IN..</h2></td></tr>
	<tr>
		<td class='first-col'>Instructor ID No:</td>
		<td><input type=number required title="NUMBERIC VALUE" name='idno' class='inputs'></td>
	</tr>

	<tr>
		<td class='first-col'>Password:</td>
		<td><input type=password required title="AVOID SPECIAL CHARACTERS" name='pass' class='inputs'></td>
	</tr>
	<tr>
	<td colspan=2>
	<input type=SUBMIT name=submit value=LOGIN ></td>
	</tr>
	</table>
<div id='fixright'>
</div>
</form>

</center>
</div>
</div>
</body>

</html>