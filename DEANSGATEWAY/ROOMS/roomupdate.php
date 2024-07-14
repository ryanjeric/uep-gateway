<?php
session_start();
if(isset($_POST['save'])){
include('conn.php');

$id=$_SESSION['id'];
$res=mysqli_query("SELECT * FROM user where id=$id") or die(mysqli_error());
$row=mysqli_fetch_array($res);

	$room=mysqli_real_escape_string($_POST['roomname']);
	$room1=mysqli_real_escape_string($_POST['roomname1']);
	$roomdesc=mysqli_real_escape_string($_POST['roomdesc']);
	$type=mysqli_real_escape_string($_POST['type']);
	$typeothers=mysqli_real_escape_string($_POST['typeothers']);
	$vent=mysqli_real_escape_string($_POST['vent']);
	$seat=mysqli_real_escape_string($_POST['seats']);
	$area=mysqli_real_escape_string($_POST['area']);
	$remarks=mysqli_real_escape_string($_POST['remarks']);
	$postedby=$row['lname'];
	$roomz=mysqli_query("SELECT * FROM roomstbl where roomname='$room'") or die(mysqli_error());
	$count=mysqli_num_rows($roomz);


	
	if($room==$room1)
	{
					$query1="UPDATE roomstbl SET roomname='$room', roomdesc='$roomdesc',type='$type', typeothers='$typeothers',ventilation='$vent',seatcap='$seat',area='$area',remarks='$remarks',postedby='$postedby' WHERE ctr={$_POST['id']}";
				$r=mysqli_query($query1);
		
				if (mysqli_affected_rows()==1)
				{	
				echo'<script type="text/javascript">alert("UPDATE SUCCESSFULL");</script>';
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
				} 
				else 
				{
				echo'<script type="text/javascript">alert("NO CHANGES!");</script>';
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
				}
	}
	else if($count==1)
		{
			echo'<script type="text/javascript">alert("ROOM ALREADY EXIST!");</script>';
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
	else
	{
			$query1="UPDATE roomstbl SET roomname='$room', roomdesc='$roomdesc',type='$type', typeothers='$typeothers',ventilation='$vent',seatcap='$seat',area='$area',remarks='$remarks',postedby='$postedby' WHERE ctr={$_POST['id']}";
				$r=mysqli_query($query1);
		
				if (mysqli_affected_rows()==1)
				{	
				echo'<script type="text/javascript">alert("UPDATE SUCCESSFULL");</script>';
				echo'<script language="JavaScript"> window.location.href =" index.php" </script>';
				} 
				else 
				{
				echo'<script type="text/javascript">alert("NO CHANGES!");</script>';
				echo'<script language="JavaScript"> window.location.href =" index.php" </script>';
				}
	}
}
else
{
	header("Location: index.php");
}

?>