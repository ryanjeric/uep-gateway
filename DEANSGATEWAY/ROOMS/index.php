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
require "../list-table-css.txt";
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
<a class='spanhead'>Rooms</a>
<a href='../deanshome.php' class='back'>&#8629 Back to Home</a>
</span>
<br>
<br>
<center>
<?php
$room=mysqli_query("SELECT * FROM roomstbl order by ctr") or die(mysqli_error());


	$roomnumber=mysqli_num_rows($room);

	echo"<table class='list2'>
		<tr>
			<td colspan='8'>No. of Rooms : $roomnumber
				<a href='addroom.php' class='new-or-add'>+Add room</a></td>
		</tr>
		<tr>
			<td>ctr</td>
			<td>RoomName</td>
			<td>Description</td>
			<td>Type</td>
			<td>Type-others</td>
			<td>Capacity</td>
			<td>Postedby</td>
			<td width=100px>Action</td>
		</tr>";
		$num=0;
		while($rms=mysqli_fetch_array($room))
		{
			$number=1+$num;
			$roomid=$rms["ctr"];
			echo'
				<tr>
					<td>'.$number.'</td>
					<td>'.$rms["roomname"].'</td>
					<td>'.$rms["roomdesc"].'</td>
					<td>'.$rms["type"].'</td>
					<td>'.$rms["typeothers"].'</td>
					<td>'.$rms["seatcap"].'</td>
					<td>'.$rms["postedby"].'</td>
					<td>';
					?>
					<?php
						$sched=mysqli_query("SELECT * FROM schedule where room=$roomid and term=$sem");
						$roomcount=mysqli_num_rows($sched);
						
						$schedz=mysqli_query("SELECT * FROM schedule where room=$roomid");
						$roomcountz=mysqli_num_rows($schedz);

						if($roomcount>=1)
						{
								echo'<form method=POST action=roomsched.php>
								<input type=hidden value="'.$rms["ctr"].'" name=roomid>
								<input type="submit" value="USED" title="USED" name=submit></form>';
						}
						else if($roomcountz>=1)
						{
								echo'<input type="submit" value="UNUSED" title="UNUSED">';
						}
						else
						{
					?>
						<form method="POST" action="editroom.php?id=<?php echo''.$rms["ctr"].''; ?>">
						<input type="submit" value="Edit" name="editroom" style='float:left'>
						</form>
						<form method=POST action="deleteroom.php?id=<?php echo''.$rms["ctr"].''; ?>">
						<span onclick="return confirm('Are you sure you want to delete this Room?')">
						<input type="submit" value="Delete" name="delroom" style='margin-left:5px;'>
						</form>
						</span>
					</td>
				<?php 
				}

				echo'</tr>';
				$num++;
		}
		?>


	</table><br>
	<div style="float:left;margin-left:200px;">


	</div>
</div>
</div>
</body>
</html>