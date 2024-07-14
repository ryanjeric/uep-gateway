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
require "../../frame-css.txt"; 
require "../../list-table-css.txt";
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
header('location:../../index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:../../chooseterm.php');
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
<a href='index.php' class='back'>&#8629 Back</a>
</span>
<br>
<br>
<center>
<?php
if(isset($_POST['submit']))
{
$roomctr=$_POST['roomid'];
$semid=$_POST['semid'];

$sql_term = mysqli_query("SELECT * FROM semtbl WHERE id = '$semid' ") or die(mysqli_error());
$term = mysqli_fetch_array($sql_term);

$room=mysqli_query("SELECT * FROM roomstbl where ctr=$roomctr") or die(mysqli_error());
	echo"<table class='report-table1'>
		<tr head>
			<td>RoomName</td>
			<td>Description</td>
			<td>Type</td>
			<td>Type-others</td>
			<td>Capacity</td>
			<td>Postedby</td>
		</tr>";
			$rms=mysqli_fetch_array($room);
			$roomid=$rms["ctr"];
			echo'
				<tr>
					<td>'.$rms["roomname"].'</td>
					<td>'.$rms["roomdesc"].'</td>
					<td>'.$rms["type"].'</td>
					<td>'.$rms["typeothers"].'</td>
					<td>'.$rms["seatcap"].'</td>
					<td>'.$rms["postedby"].'</td>';
				echo'</tr></table><br>';
				
		$sched=mysqli_query("SELECT * FROM SCHEDULE where room=$roomctr and term=$semid ORDER BY starthr asc,startmin asc,starttypeday asc");
		$countt=mysqli_num_rows($sched);

		echo"<table class='report-table1'>
		<tr><td colspan='6'><b>School Year: $term[syear] $term[sem]</b> </td></tr>
		<tr head>
			<td>Time</td>
			<td>Subj Code</td>
			<td>Subj Description</td>
			<td>DAYS</td>
			<td>Assigned Faculty</td>
			<td>Number of Students</td>
		</tr>
		";
		if($countt==0)
		{
			echo'<script type="text/javascript">alert("NO FOUND SCHEDULE IN THIS ROOM OR TERM");</script>';
			echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
			while($sch=mysqli_fetch_array($sched))
			{
						$courseid=$sch['courseid'];
							
						$course=mysqli_query("SELECT * FROM coursetbl where id=$courseid");
						$coursef=mysqli_fetch_array($course);

						if($sch["endmin"] == 0) { $endmin = "00";}
						else {$endmin = $sch["endmin"];}

						if($sch["startmin"] == 0) { $startmin = "00";}
						else {$startmin = $sch["startmin"];}

						echo'<tr>
						<td>'.$sch["starthr"].':'.$startmin.' '.$sch["starttypeday"].' -
								'.$sch["endhr"].':'.$endmin.' '.$sch["endtypeday"].'</td>';
						echo"<td>".$coursef['coursecode']."</td>
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
							
						
						echo'</td><td>';
													$instructor=$sch["instructor"];
													$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
													$insz=mysqli_fetch_array($insquery);
													echo"".$insz['lname'].",".$insz['gname']."";

								echo'</td>
								<td>';
										$StudentsNO=mysqli_query("SELECT * FROM studentssubjtbl where courseid=$courseid and term=$semid");
										$count=mysqli_num_rows($StudentsNO);

										echo''.$count.'';



								echo'</td>
							</tr>';
			}
			echo"</table>
				</center>
				<br>
				<span tenpercent>
				<form method=POST action=print.php target=_blank>
				
								<input type=hidden value=".$roomctr." name=roomid>
								<input type=hidden value=".$semid." name=semid>
					<a href='../../deanshome.php' buttonlike>HOME</a>
					<input type=submit value=PRINT title=SCHEDULE name=print>
					<a href='../index.php' buttonlike>REPORTS</a>
				</form>
				</span>
				<br><br>";
				
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