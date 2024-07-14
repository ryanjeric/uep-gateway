<?php
session_start();
if(isset($_POST['save'])){
include('conn.php');

$id=$_SESSION['id'];
$res=mysqli_query("SELECT * FROM user where id=$id") or die(mysqli_error());
$row=mysqli_fetch_array($res);

	$prog=mysqli_real_escape_string($_POST['prog']);
	$prog1=mysqli_real_escape_string($_POST['prog1']);
	$abb=mysqli_real_escape_string($_POST['abb']);

	$progz=mysqli_query("SELECT * FROM programs where programdesc='$prog'") or die(mysqli_error());
	$count=mysqli_num_rows($progz);


	
	if($prog==$prog1)
	{
					$query1="UPDATE programs SET programdesc='$prog', abbreviation='$abb' WHERE id={$_POST['id']}";
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
			echo'<script type="text/javascript">alert("PROGRAM ALREADY EXIST!");</script>';
				echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
		}
	else
	{
			$query1="UPDATE programs SET programdesc='$prog', abbreviation='$abb' WHERE id={$_POST['id']}";
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