<?php
session_start();
if(isset($_POST['save'])){
include('conn.php');

	$lname=mysqli_real_escape_string(ucwords(strtolower($_POST['lname'])));
	$gname=mysqli_real_escape_string(ucwords(strtolower($_POST['gname'])));
	$empid=mysqli_real_escape_string($_POST['empid']);
	$empid1=mysqli_real_escape_string($_POST['empid1']);
	$des=mysqli_real_escape_string($_POST['designation']);
	$datehired=mysqli_real_escape_string($_POST['datehired']);
	$pass=mysqli_real_escape_string($_POST['pass']);
	
$staffz=mysqli_query("SELECT * FROM registrar where empid='$empid'") or die(mysqli_error());
	$count=mysqli_num_rows($staffz);

	
	if($empid1==$empid)
	{
					$query1="UPDATE registrar SET empid='$empid', lname='$lname',gname='$gname', designation='$des',datehired='$datehired',password='$pass' WHERE ctr={$_POST['id']}";
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
			echo'<script type="text/javascript">alert("INSTRUCTOR ALREADY EXIST!");</script>';
				echo'<script language="JavaScript"> window.location.href =" index.php" </script>';
		}
	else
	{
			$query1="UPDATE registrar SET empid='$empid', lname='$lname',gname='$gname', designation='$des',datehired='$datehired',password='$pass' WHERE ctr={$_POST['id']}";
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