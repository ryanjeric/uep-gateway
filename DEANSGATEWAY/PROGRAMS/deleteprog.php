<?php
if(isset($_POST['delprog']))
{
include('conn.php');
$query="DELETE from programs where id={$_GET['id']} LIMIT 1";
$r = mysqli_query($query);
if(mysqli_affected_rows()==1)
		{
		echo'<script type="text/javascript">alert("The record has been successfully Deleted.");</script>';
		echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
		else
		{
		echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
}
else{header("location:index.php");}
?>