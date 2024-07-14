<?php
if(isset($_POST['delsched']))
{
	session_start();
	$sem=$_SESSION['sem'];
include('conn.php');
$query="DELETE from Schedule where courseid={$_GET['id']} and term=$sem";
$r = mysqli_query($query);
if(mysqli_affected_rows()==1)
		{
		echo'<script type="text/javascript">alert("The Schedule has been successfully Deleted.");</script>';
		echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
		else
		{
		echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
}
else{header("location:index.php");}
?>