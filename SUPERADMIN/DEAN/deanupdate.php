<?php
session_start();
if(isset($_POST['save'])){
include('conn.php');

	$lname=mysqli_real_escape_string(ucwords(strtolower($_POST['lname'])));
	$fname=mysqli_real_escape_string(ucwords(strtolower($_POST['fname'])));
	$mname=mysqli_real_escape_string(ucwords(strtolower($_POST['mname'])));
	$empid0=mysqli_real_escape_string($_POST['empid0']);
	$empid1=mysqli_real_escape_string($_POST['empid1']);
	$dept=mysqli_real_escape_string(strtoupper($_POST['department']));
	$datehired=mysqli_real_escape_string($_POST['datehired']);
	
	$staffz=mysqli_query("SELECT * FROM user where empid='$empid1'") or die(mysqli_error());
	$count=mysqli_num_rows($staffz);

	
	if($empid0==$empid1)
	{
				$query1="UPDATE user SET lname='$lname', fname='$fname', mname='$mname', department='$dept', datehired='$datehired' WHERE empid='$empid1'";
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
	else if($count==1)
		{
			echo'<script type="text/javascript">alert("WARNING! EMPLOYEE ID ALREADY EXIST!");</script>';
				echo'<script language="JavaScript"> window.location.href =" index.php" </script>';
		}
	else
	{
			$query1="UPDATE user SET empid='$empid1', lname='$lname', fname='$fname', mname='$mname', department='$dept', datehired='$datehired' WHERE empid='$empid0' ";
				$r=mysqli_query($query1);
		
				if (mysqli_affected_rows()==1)
				{	
				echo'<script type="text/javascript">alert("UPDATE SUCCESSFULL");</script>';
				echo'<script language="JavaScript"> window.location.href =" index.php" </script>';
				} 
				else 
				{
				echo'<script type="text/javascript">alert("NO CHANGES HAD MADE!");</script>';
				echo'<script language="JavaScript"> window.location.href =" index.php" </script>';
				}
	}
}
else
{
	header("Location: index.php");
}

?>