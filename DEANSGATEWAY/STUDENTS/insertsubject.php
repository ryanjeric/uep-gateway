<?php

				if(isset($_POST['addsubject']))
				{
					include('conn.php');
					$student=$_POST['student'];
					$term=$_POST['term'];

					if(isset($_POST['course']))
					{
					$array=$_POST['course'];
					foreach ($array as $courseid) {
						$query=mysqli_query("INSERT INTO studentssubjtbl values($term,$courseid,$student)") or die(mysqli_error());
					}
					echo "<script>alert('SUBJECT ADDED')</script>";
					echo'<script language="JavaScript"> window.location.href ="StudentsSubject.php?id='.$student.'"</script>';
					}
					else
					{
					echo "<script>alert('PLEASE CHECK A SUBJECT')</script>";
					echo'<script language="JavaScript"> window.location.href ="StudentsSubject.php?id='.$student.'"</script>';
					}

				}
				else
				{
					header('location:index.php');
				}



?>