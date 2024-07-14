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
<a class='spanhead'>Room Schedule</a>
<a href='index.php' class='back'>&#8629 Back to Rooms</a>
</span>
<br>
<br>
<center>
<?php
if(isset($_POST['submit']))
{
$roomctr=$_POST['roomid'];
$room=mysqli_query("SELECT * FROM roomstbl where ctr=$roomctr") or die(mysqli_error());
	echo"<table class='simple-style1'>
		<tr small-head-one>
			<td align=center>RoomName</td>
			<td align=center>Description</td>
			<td align=center>Type</td>
			<td align=center>Type-others</td>
			<td align=center>Capacity</td>
			<td align=center>Posted by</td>
		</tr>";
			$rms=mysqli_fetch_array($room);
			$roomid=$rms["ctr"];
			echo'
				<tr small-head-two>
					<td align=center>'.$rms["roomname"].'</td>
					<td align=center>'.$rms["roomdesc"].'</td>
					<td align=center>'.$rms["type"].'</td>
					<td align=center>'.$rms["typeothers"].'</td>
					<td align=center>'.$rms["seatcap"].'</td>
					<td align=center>'.$rms["postedby"].'</td>';
				echo'</tr></table><br>';
				
		$sched=mysqli_query("SELECT * FROM SCHEDULE where room=$roomctr and term=$sem");
		echo"<table class='style-schedule'>
		<tr head>
			<td>ClassType</td>
			<td>CourseCode</td>
			<td>Course Description</td>
			<td>DAYS</td>
			<td>StartTime</td>
			<td>EndTime</td>
			<td>Instructor</td>
			<td>Remarks</td>
		</tr>
		";
			while($sch=mysqli_fetch_array($sched))
			{
				echo'<tr>
						<td>'.$sch["classtype"].'</td>
						<td>';
						$courseid=$sch['courseid'];
							
						$course=mysqli_query("SELECT * FROM coursetbl where id=$courseid");
						$coursef=mysqli_fetch_array($course);
						echo"".$coursef['coursecode']."</td>
						<td>".$coursef['coursedesc']."</td><td>";
						 
						 		if($sch['m']==1)
								{
									echo'M ';
								}
								if($sch['t']==1)
								{
									echo'T ';
								}
								if($sch['w']==1)
								{
									echo'W ';
								}
								if($sch['th']==1)
								{
									echo'TH ';
								}
								if($sch['f']==1)
								{
									echo'F ';
								}
								if($sch['s']==1)
								{
									echo'S ';
								}
								if($sch["startmin"] == 0) { $startmin = "00";}
                                else {$startmin = $sch["startmin"];}

                                if($sch["endmin"] == 0) { $endmin = "00";}
                                else {$endmin = $sch["endmin"];}

							echo'</td>
							<td>'.$sch["starthr"].':'.$startmin.' '.$sch["starttypeday"].'</td>
								<td>'.$sch["endhr"].':'.$endmin.' '.$sch["endtypeday"].'</td>';
						
						echo'<td>';
													$instructor=$sch["instructor"];
													$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
													$insz=mysqli_fetch_array($insquery);
													echo"".$insz['lname'].",".$insz['gname']."";

								echo'</td>
								<td>'.$sch["remarks"].'</td>
							</tr>';
			}
			echo"</table><br>";
				
}
	else
	{
		header("Location: index.php");
	}
		?>


	
	<div style="float:left;margin-left:200px;">


	</div>
</div>
</div>
</body>
</html>