<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php require "indexcss.txt"; ?>
</style>
</head>
<body>
<div warp>

<br>
<div d2>
<?php 
include('conn.php'); 
session_start();
if(isset($_SESSION['id']))
{
header('location:chooseterm.php');
}
if(isset($_POST['submit'])){
$emp=mysqli_real_escape_string($_POST['empid']);
$Password=mysqli_real_escape_string($_POST['pass']);
	if($emp=="" and $Password=="")
	{
		echo'<script type="text/javascript">alert("All fields are required!");</script>';
		echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
	}
	else
	{
	$result=mysqli_query("SELECT * FROM user where empid='$emp' and password='$Password' and position='DEAN' LIMIT 1") or die(mysqli_error());
	
	$count=mysqli_num_rows($result);
	$row=mysqli_fetch_array($result);
	
	if ($count>0){
	session_start();
	$_SESSION['id']=$row['id'];
	$id=$row['id'];
	$_SESSION['logged']= TRUE;
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
$usr=&$_POST['empid'];
$pas=&$_POST['pass'];
?>
<form method=POST>
<div id='fixleft'>
</div>
	<table id='tbl-login'>
	<tr>
		<td rowspan='5' class='leftside'><a href='../'><img src='redstar.png' id='redstar' /></a>
		<br>
		<abbr uep>UEP</abbr> <br>
		UNIVERSITY of <Br>
		EASTERN PANGASINAN
		</td>
	</tr>
	
	<tr><td colspan='2'><h2>Dean's LOG-IN..</h2></td></tr>
	<tr>
		<td class='first-col'>Employee ID:</td>
		<td><input type=number required title="NUMBERIC VALUE" name=empid class='inputs' autofocus></td>
	</tr>

	<tr>
		<td class='first-col'>Password:</td>
		<td><input type=password required title="AVOID SPECIAL CHARACTERS" name=pass class='inputs'></td>
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