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
if (!isset($_SESSION['id2'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem3']))
{
header('location:../chooseterm.php');
}
?>
<?php
$id=$_SESSION['id2'];
$sem=$_SESSION['sem3'];
$res=mysqli_query("SELECT * FROM registrar where ctr=$id") or die(mysqli_error());
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
<a class='spanhead'>Edit Course</a>
<a href='index.php' class='back' title='Cancel adding of course' >&#8629 Back to Courses</a>
</span>

<?php
if(isset($_POST['editcourse']))
{
	if(is_numeric ($_GET['id'])){
		$query = "SELECT * FROM coursetbl WHERE id={$_GET['id']}";
		if ($r = mysqli_query($query)){
		$row = mysqli_fetch_array ($r);
		
		$labtypez=$row['labtype'];
		
		echo"<form method=post id=savecourse action='courseupdate.php'>";
		
		?>
	<table class='fillup-simple1'>
		<tr>
			<td>Course Code <br>
				<input type="hidden" name="coursecode1" value="<?php echo''.$row["coursecode"].''; ?>">
				<input type="text" name="coursecode" required value="<?php echo''.$row["coursecode"].''; ?>">
			</td>
			<td>Course Description <br>
				<input type="text" name="coursedesc" required value="<?php echo''.$row["coursedesc"].''; ?>">
			</td>
		</tr>
		<tr>
			<td>Section <br>
				<input type="hidden" name="section1" value="<?php echo''.$row["section"].''; ?>">
				<input type="text" name="section" required value="<?php echo''.$row["section"].''; ?>">
			</td>
			<td>No. of Lecture <br>
				<input type="number" name="lec" required value="<?php echo''.$row["nolec"].''; ?>">
			</td>
		</tr>
		<tr>
			<td>No. of Lab <br>
				<input type="number" name="lab" required value="<?php echo''.$row["nolab"].''; ?>">
			</td>
			<td>Lab Type <br>
				<select name=labtype>
						<option <?php if($labtypez=='_/_'){echo "selected";}?> value="_ /_">-/-</option>
						<option <?php if($labtypez=='AVR'){echo "selected";}?> value="AVR">AVR</option>
						<option <?php if($labtypez=='Cisco Room'){echo "selected";}?> value="Cisco Room">Cisco Room</option>
						<option <?php if($labtypez=='Physics Lab Room'){echo "selected";}?> value="Physics Lab Room">Physics Lab Room</option>
						<option <?php if($labtypez=='Chem Lab Room'){echo "selected";}?> value="Chem Lab Room">Chem Lab Room</option>
						<option <?php if($labtypez=='Bio Lab Room'){echo "selected";}?> value="Bio Lab Room">Bio Lab Room</option>
						<option <?php if($labtypez=='Others'){echo "selected";}?> value="Others">Others</option>
					</select>
			</td>
		</tr>
		<tr>
			<td>Slots <br>
				<input type="number" name="slots" required value="<?php echo''.$row["slots"].''; ?>">
				<input type="hidden" name="sluts" required value="<?php echo''.$row["slots"].''; ?>">
			</td>
			<td></td>
		</tr>
		<tr>
			<td colspan='2'><br><?php 
				echo'
				<input type="hidden" name="id" value="'.$row["id"].'" />'; ?>
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