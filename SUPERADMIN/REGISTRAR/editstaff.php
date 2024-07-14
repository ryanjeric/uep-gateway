<?php
ob_start();
include('conn.php');
session_start();
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
<a class='spanhead'>Edit Registrar</a>
<a href='index.php' class='back' title='Cancel editing of Staff' >&#8629 Back to Registrar</a>
</span>
<?php
if(isset($_POST['editstaff']))
{
	if(is_numeric ($_GET['id'])){
		$query = "SELECT * FROM registrar WHERE ctr={$_GET['id']}";
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
				<select name="designation" required>
					<option <?php if($des == 'REGISTRAR'){ echo(' selected '); } ?> value="REGISTRAR">REGISTRAR</option>
					<option <?php if($des == 'ASSISTANT CLERK'){ echo(' selected '); } ?> value="ASSISTANT CLERK">ASSISTANT CLERK</option>
				</select>
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
		<tr>
			<td>Date Hired <br>
			<input type=text name="datehired" value="<?php echo''.$row["datehired"].''; ?>">
			</td>
			<td>
			</td>
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