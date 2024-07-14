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
if (!isset($_SESSION['id'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:../chooseterm.php');
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
<?php
include "info.php";
?>

<div d2>
<span class='divhead'>
<a class='spanhead'>Edit Staff</a>
<a href='index.php' class='back' title='Cancel editing of Staff' >&#8629 Back to Staff</a>
</span>
<?php
if(isset($_POST['editstaff']))
{
	if(is_numeric ($_GET['id'])){
		$query = "SELECT * FROM staff WHERE ctr={$_GET['id']}";
		if ($r = mysqli_query($query)){
		$row = mysqli_fetch_array ($r);
		
		$des=$row['designation'];
		
		echo"<form method=post id=staff action='staffupdate.php'>";
		
		?>
	<table class='fillup-simple1'>
		<tr>
			<td>Employee Number <br>
				<input type="hidden" name="empid1" required value="<?php echo''.$row["empid"].''; ?>">
				<input type="text" name="empid" required value="<?php echo''.$row["empid"].''; ?>">
			</td>
			<td>Designation <br>
				<input type=text name="designation" required value="<?php echo''.$row["designation"].''; ?>">
			</td>
		</tr>
		<tr>
			<td>Last Name <br>
				<input type=text name="lname" required value="<?php echo''.$row["lname"].''; ?>">
			</td>
			<td>Given Name <br>
				<input type=text name="gname" required value="<?php echo''.$row["gname"].''; ?>">
			</td>	
		</tr>
		<tr><td>Department <br>
				<input type=text name="dep" required value="<?php echo''.$row["department"].''; ?>">
			</td>
			<td>Date Hired <br>
				<input type=date name="datehired" value="<?php echo''.$row["datehired"].''; ?>">
			</td>
		</tr>
		<tr>
			
		</tr>
		<tr>
			<td colspan='2'><br><?php 
			echo'
			<input type="hidden" name="id" value="'.$row["ctr"].'" />'; ?>
			<input type=submit value='Save' name=save class='button'>
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