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
<a class='spanhead'>Edit Program</a>
<a href='index.php' class='back' title='Cancel adding of room' >&#8629 Back to Programs</a>
</span>
<center>
<?php
if(isset($_POST['editprog']))
{
	if(is_numeric ($_GET['id'])){
		$query = "SELECT * FROM programs WHERE id={$_GET['id']}";
		if ($r = mysqli_query($query)){
		$row = mysqli_fetch_array ($r);
		
		echo"<form method=post id=saveprog action='progupdate.php'>";
		
		?>
	<table class='fillup-simple1'>
		<tr>
			<td>Program Description <br>
				<input type="hidden" name="prog1" required value="<?php echo''.$row["programdesc"].''; ?>"><input type="text" name="prog" required value="<?php echo''.$row["programdesc"].''; ?>">
			</td>
			<td>Abbreviation <br>
				<input type="text" name="abb" required value="<?php echo''.$row["abbreviation"].''; ?>">
			</td>
		</tr>
		<tr>
			<td colspan='2'> <br> <?php 
				echo'
				<input type="hidden" name="id" value="'.$row["id"].'" />'; ?>
				<input type=submit value='Save' name=save class='button'>
				<span label><font color=red>Warning!!</font>be sure to follow the format indicated opposite the field or ERROR will result in submission</span>
			</td>
		</tr>
			
	</table>
	</form>
</center>
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