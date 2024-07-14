<?php
		if(isset($_POST['del']))
		{
			include("conn.php");
			$term=$_POST['term'];
			$subj=$_POST['course'];
			$stud=$_POST['stud'];

			mysqli_query("DELETE from studentssubjtbl where term=$term and courseid=$subj and studentid=$stud") or die(mysqli_error());

			echo "<script>alert('Deleted')</script>";
			echo'<script language="JavaScript"> window.location.href ="StudentsSubject.php?id='.$stud.'" </script>';
		}
		else
		{
			header('location:index.php');
		}


?>