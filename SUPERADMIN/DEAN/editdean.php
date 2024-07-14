<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php 
require "../frame-css.txt";
require "../fillup-table-css.txt";
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
$res=mysqli_query("SELECT * FROM superadmin where superadmin_empid=$id") or die(mysqli_error());
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
<a class='spanhead'>Edit Dean</a>
<a href='index.php' class='back' title='Cancel editing of Dean' >&#8629 Back</a>
</span>
<?php
if(isset($_POST['edit']))
{
	if(is_numeric ($_POST['empid'])){
		$query = "SELECT * FROM user where empid='$_POST[empid]' ";
		if ($r = mysqli_query($query)){
		$row = mysqli_fetch_array ($r);
		
		echo"<form method=post action='deanupdate.php'>";
		?>
	<table class='fillup-simple1'>
		<tr>
				<td>Employee ID<br>
					<input type='hidden' name='empid0' value='<?php echo $row['empid'];?>'>
					<input type="text" name="empid1" value='<?php echo $row['empid'];?>' required>
				</td>
				<td>
					Department<br>
					<input type=text name="department" value='<?php echo $row['department'];?>' required>
				</td>
			</tr>
			<tr>
				<td>First Name <br>
					<input type=text name="fname" value='<?php echo $row['fname'];?>' required>
				</td>
				<td>Middle Name <br>
					<input type=text name="mname" value='<?php echo $row['mname'];?>' required>
				</td>
			</tr>
			<tr>
				<td>Last Name <br>
					<input type=text name="lname" value='<?php echo $row['lname'];?>' required>
				</td>
				<td>Date Hired <br>
					<input type=text name="datehired" value='<?php echo $row['datehired'];?>' required placeholder="MM/DD/YYYY">
				</td>
			</tr>
		<tr>
			<td colspan='2'><br><?php 
			echo'
			<input type="hidden" name="empid" value="'.$row["empid"].'" />'; ?>
			<input type=submit value='Save' name='save' class='button'>
			<span label><font color=red>Warning!!</font>be sure to follow the format indicated opposite the field or ERROR will result in submission</span>
			</td>
		</tr>
			
	</table>
	</form>
<?php
		}	
	}
}
else
{
	header("Location: index.php");
exit;
}
?>
<br>
</div>
</div>
</body>
</html>