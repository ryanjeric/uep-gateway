<?php
if(isset($_POST['delete']))
{
include('conn.php');
$query="UPDATE registrar set status='DELETED' WHERE ctr={$_POST['id']}";
$r = mysqli_query($query);
if(mysqli_affected_rows()==1)
		{
		echo'<script type="text/javascript">alert("The record has been successfully DeLeted.");</script>';
		echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
		else
		{
		echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
}
else{header("location:index.php");}
?>