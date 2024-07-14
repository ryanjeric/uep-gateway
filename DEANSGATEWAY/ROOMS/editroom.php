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
<a class='spanhead'>Edit Room</a>
<a href='index.php' class='back' title='Cancel adding of room' >&#8629 Back to Rooms</a>
</span>

<?php
if(isset($_POST['editroom']))
{
	if(is_numeric ($_GET['id'])){
		$query = "SELECT * FROM roomstbl WHERE ctr={$_GET['id']}";
		if ($r = mysqli_query($query)){
		$row = mysqli_fetch_array ($r);
		
		$vent=$row['ventilation'];
		$type=$row['type'];
		
		
		echo"<form method=post id=saveroom action='roomupdate.php'>";
		
		?>
	<table class='fillup-simple1'>
			<tr>
				<td>Room Name <br>
					<input type="hidden" name="roomname1" required value="<?php echo''.$row["roomname"].''; ?>">
					<input type="text" name="roomname" required value="<?php echo''.$row["roomname"].''; ?>">
					<br>
					<span label>this must be unique.Examples : BlueRoom,Room_A,AVR</span>
				</td>
				<td>Room Description <br>
					<textarea name="roomdesc"><?php echo''.$row["roomdesc"].''; ?></textarea>
				</td>
			<tr>
				<td>Type <br>
					<select name="type" required>
						<option <?php if($type == 'Lecture Room'){ echo(' selected '); } ?> value="Lecture Room">Lecture Room</option>
						<option <?php if($type == 'Lab Room'){ echo(' selected '); } ?> value="Lab Room">Lab Room</option>
						<option <?php if($type == 'AVR'){ echo(' selected '); } ?> value="AVR">AVR</option>
						<option <?php if($type == 'Cisco Room'){ echo(' selected '); } ?> value="Cisco Room">Cisco Room</option>
						<option <?php if($type == 'Physics Lab Room'){ echo(' selected '); } ?> value="Physics Lab Room">Physics Lab Room</option>
						<option <?php if($type == 'Chem Lab Room'){ echo(' selected '); } ?> value="Chem Lab Room">Chem Lab Room</option>
						<option <?php if($type == 'Bio Lab Room'){ echo(' selected '); } ?> value="Bio Lab Room">Bio Lab Room</option>
						<option <?php if($type == 'Office'){ echo(' selected '); } ?> value="Office">Office</option>
						<option <?php if($type == 'MultiPurpose Room'){ echo(' selected '); } ?> value="MultiPurpose Room">MultiPurpose Room</option>
						<option <?php if($type == 'Library'){ echo(' selected '); } ?>value="Library">Library</option>
						<option <?php if($type == 'Others'){ echo(' selected '); } ?> value="Others">Others</option>
					</select> <br>
					<span label>if not listed ,pls. Select OTHERS and write TYPE in the next field below.</span>
				</td>
				<td>Type-others <br>
					<input type=text name="typeothers" value="<?php echo''.$row["typeothers"].''; ?>">
				</td>
			</tr>
			<tr>
				<td>Ventilation <br>
					<select name="vent" required>
						<option <?php if($vent == 'With AirCon'){ echo(' selected '); } ?> value="With AirCon">With AirCon</option>
						<option <?php if($vent == 'Without AirCon'){ echo(' selected '); } ?> value="Without AirCon">Without AirCon</option>
					</select>
				</td>
				<td> Seating capacity <br>
					<input type=number name="seats" required value="<?php echo''.$row["seatcap"].''; ?>">
					<br><span label>Numbers only</span>
				</td>
			</tr>
			<tr>
				<td>Total Flr area (sq. m) <br>
					<input type=number name="area" value="<?php echo''.$row["area"].''; ?>">
					<br><span label>Numbers only</span>
				</td>
				<td>Remarks (optional) <br>
					<textarea name="remarks"><?php echo''.$row["remarks"].''; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan='2'><br>
					<?php 
						print'
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