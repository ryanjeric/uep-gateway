<?php
session_start();
if(isset($_POST['save'])){
include('conn.php');

	$coursecode=mysqli_real_escape_string($_POST['coursecode']);
		$coursecode1=mysqli_real_escape_string($_POST['coursecode1']);
	$coursedesc=mysqli_real_escape_string($_POST['coursedesc']);
	$section=mysqli_real_escape_string($_POST['section1']);
		$section1=mysqli_real_escape_string($_POST['section']);
	$lec=mysqli_real_escape_string($_POST['lec']);
	$lab=mysqli_real_escape_string($_POST['lab']);
	$labtype=mysqli_real_escape_string($_POST['labtype']);
	$slot=mysqli_real_escape_string($_POST['slots']);
	$slut=mysqli_real_escape_string($_POST['sluts']);

	$coursez=mysqli_query("SELECT * FROM coursetbl where coursecode='$coursecode' and section='$section'") or die(mysqli_error());
	$count=mysqli_num_rows($coursez);

	if($slut>$slot)
	{
				echo'<script type="text/javascript">alert("UNABLE TO UPDATE SLOTS");</script>';
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
				exit();
	}
	
	if($coursecode==$coursecode1 and $section==$section1)
	{
					$query1="UPDATE coursetbl SET coursecode='$coursecode', coursedesc='$coursedesc', section='$section', nolec='$lec', nolab='$lab', labtype='$labtype', slots='$slot' WHERE id={$_POST['id']}";
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
			echo'<script type="text/javascript">alert("COURSE ALREADY EXIST IN THIS SECTION!");</script>';
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
	else
	{
	$query1="UPDATE coursetbl SET coursecode='$coursecode', coursedesc='$coursedesc', section='$section', nolec=$lec, nolab=$lab, labtype='$labtype', slots=$slot WHERE id={$_POST['id']}";
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