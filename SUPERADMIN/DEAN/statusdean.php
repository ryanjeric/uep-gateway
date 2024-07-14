<?php
if(isset($_POST['status']))
{
	if($_POST['status'] == 'ACTIVATE') {

		include('conn.php');
		$query="UPDATE user set status='ACTIVATED' WHERE empid='$_POST[empid]' ";
		$r = mysqli_query($query);
		if(mysqli_affected_rows()==1)
				{
				echo'<script type="text/javascript">alert("The record has been successfully Activated.");</script>';
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
				}
				else
				{
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
				}
	}
	else {
		include('conn.php');
		$query="UPDATE user set status='DEACTIVATED' WHERE empid='$_POST[empid]' ";
		$r = mysqli_query($query);
		if(mysqli_affected_rows()==1)
				{
				echo'<script type="text/javascript">alert("The record has been successfully Deactivated.");</script>';
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
				}
				else
				{
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
				}
	}
}
else{
	header("location:index.php");
}
?>