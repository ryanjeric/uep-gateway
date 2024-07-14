<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>EUP - SUPERADMIN</title>
<style>
<?php 
require "frame-css.txt";
require "fillup-table-css.txt";
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
include('conn.php');
session_start();
if (!isset($_SESSION['super_id'])){
header('location:../index.php');
}
if(!isset($_SESSION['super_sem']))
{
header('location:../chooseterm.php');
}
?>
<?php
$id=$_SESSION['super_id'];
$sem=$_SESSION['super_sem'];
$res=mysqli_query("SELECT * FROM superadmin where superadmin_empid =$id") or die(mysqli_error());
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
<a class='spanhead'>Update Account</a>
<a href='superadminhome.php' class='back' title='Cancel' >&#8629 Back</a>
</span>
<form method="POST">
<table class='fillup-simple1'>
	<tr>
		<td>Employee ID <br>
			<input type="text" name="empid" value="<?php echo $row['superadmin_empid'];?>" required>
		</td>
		<td>First Name <br>
			<input type="text" name="fname" value="<?php echo $row['superadmin_fname'];?>" required>
		</td>
	</tr>
	<tr>
		<td>Middle Name <br>
			<input type="text" name="mname" value="<?php echo $row['superadmin_mname'];?>" required>
		</td>
		<td>Last Name <br>
			<input type="text" name="lname" value="<?php echo $row['superadmin_lname'];?>" required>
		</td>
	</tr>
	<tr>
			<td colspan='2'>
			<input type=submit value='Save' name='save' class='button'>
			<span label>Note: After the changes has been saved, your account will logout automatically</span>
			</td>
		</tr>
</table>
</form>
<br>
</div>
</div>
</body>
</html>
<?php
if(isset($_POST['save'])) {
	$empid=mysqli_real_escape_string($_POST['empid']);
	$lname=mysqli_real_escape_string(ucwords(strtolower($_POST['lname'])));
	$fname=mysqli_real_escape_string(ucwords(strtolower($_POST['fname'])));
	$mname=mysqli_real_escape_string(ucwords(strtolower($_POST['mname'])));

	$query1="UPDATE superadmin SET superadmin_empid = '$empid', superadmin_lname='$lname', superadmin_fname='$fname', superadmin_mname='$mname'  WHERE superadmin_empid='$id'";
				$r=mysqli_query($query1);
		
				if (mysqli_affected_rows()==1)
				{	
				echo'<script type="text/javascript">alert("UPDATE SUCCESSFULL");</script>';
				echo'<script language="JavaScript"> window.location.href =" logout.php" </script>';
				} 
				else 
				{
				echo'<script type="text/javascript">alert("NO CHANGES!");</script>';
				echo'<script language="JavaScript"> window.location.href =" superadminhome.php" </script>';
				}
	
}
?>