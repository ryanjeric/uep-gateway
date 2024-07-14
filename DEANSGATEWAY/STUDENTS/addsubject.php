<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php 
	require "../frame-css.txt"; 
	require "../list-table-css.txt";
?>
</style>
<script>
<?php
	require "js-time.txt";
?>
</script>
</head>
<body onload="startTime()">
<?php
if (!isset($_SESSION['id'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:../chooseterm.php');
}
?>
<?php
	$id=$_SESSION['id'];
	$sem=$_SESSION['sem'];
	$res=mysqli_query("SELECT * FROM user where id=$id") or die(mysqli_error());
	$row=mysqli_fetch_array($res);
	$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
	$rows=mysqli_fetch_array($ress);
?>
<div warp>
	<?php include "info.php"; ?>
<div d2>
<span class='divhead'>
<a class='spanhead'>Add Subject</a>
<a href='index.php' class='back' title='HOME' >&#8629 Back</a>
</span>
<br>
<br>
<center>
	<?php
			if(isset($_POST['add']))
			{
				$studid=$_POST['studid'];
				$studquery=mysqli_query("SELECT * FROM studentstbl where idno=$studid") or die(mysqli_error());
				$studfetch=mysqli_fetch_array($studquery);
				echo"<table class='simple-style1'>
				<tr><td>Year Term:</td><td>".$rows['syear']."</td></tr>
				<tr><td>ID No.:</td><td>".$studfetch['idno']."</td></tr>
				<tr><td>Student Name:</td><td>".$studfetch['lname'].", ".$studfetch['gname']."</td></tr>
				</table>
				<br>";

				$coursequery=mysqli_query("SELECT * FROM coursetbl order by coursecode") or die(mysqli_error());
				echo"<form method=POST action=insertsubject.php>
				<table class='style-schedule1'>
							<tr head>
							<td>Course ID</td>
							<td>CourseCode</td>
							<td>CourseDesciption</td>
							<td>Section</td>
							<td>Units</td>
							<td>Schedule</td>
							<td>Slots</td>
							<td>#listed</td>
							<td>Available</td>
							<td>Action</td>
							</tr>";
				while($coursefetch=mysqli_fetch_array($coursequery))
				{
					$course=$coursefetch["id"];
					$courselec=$coursefetch["nolec"];
					$courselab=$coursefetch["nolab"];
					$courseunits=0;
					$courseunits=$courselec+$courselab;


					$schedquery=mysqli_query("SELECT * FROM schedule where term=$sem and courseid=$course") or die(mysqli_error());
					$schedCount=mysqli_num_rows($schedquery);

					$squery=mysqli_query("SELECT * FROM studentssubjtbl where term=$sem and courseid=$course and studentid=$studid") or die(mysqli_error());
					$sCount=mysqli_num_rows($squery);


					if($schedCount==0)
								{
									
								}
					elseif ($sCount==1) 
								{
									
								}
					else
					{
							echo'<tr>
									<td>'.$coursefetch["id"].'</td>
									<td>'.$coursefetch["coursecode"].'</td>
									<td>'.$coursefetch["coursedesc"].'</td>
									<td>'.$coursefetch["section"].'</td>
									<td>'.$courseunits.'</td>
									<td>';
									while($schedfetch=mysqli_fetch_array($schedquery))
									{
										$roomid=$schedfetch["room"];
										$insid=$schedfetch["instructor"];
										echo'<b>'.$schedfetch["classtype"].'</b>|';

										if($schedfetch['m']==1)
										{
											echo'M';
										}
										if($schedfetch['t']==1)
										{
											echo'T';
										}
										if($schedfetch['w']==1)
										{
											echo'W';
										}
										if($schedfetch['th']==1)
										{
											echo'TH';
										}
										if($schedfetch['f']==1)
										{
											echo'F';
										}
										if($schedfetch['s']==1)
										{
											echo'S';
										}
										if($schedfetch["startmin"] == 0) { $startmin = "00";}
	                                    else {$startmin = $schedfetch["startmin"];}

	                                    if($schedfetch["endmin"] == 0) { $endmin = "00";}
	                                    else {$endmin = $schedfetch["endmin"];}

										echo'|'.$schedfetch["starthr"].' : '.$startmin.' '.$schedfetch["starttypeday"].'
										to '.$schedfetch["endhr"].' : '.$endmin.' '.$schedfetch["endtypeday"].' |';

										$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$roomid") or die(mysqli_error());
										$roomfetch=mysqli_fetch_array($roomquery);
										echo "".$roomfetch['roomname']."/".$roomfetch['type']."| ";

										$instructor=mysqli_query("SELECT * FROM staff where ctr=$insid") or die(mysqli_error());
										$insfetch=mysqli_fetch_array($instructor);
										echo''.$insfetch['lname'].', '.$insfetch['gname'].'<br>';
									}
								
							echo'</td>
							<td>'.$coursefetch["slots"].'</td>
							<td>';
								$coursezquery=mysqli_query("SELECT * FROM studentssubjtbl where courseid=$course and term=$sem") or die(mysqli_error());
								$coursecount=mysqli_num_rows($coursezquery);
								$slotz=$coursefetch["slots"];
								$Available=$slotz-$coursecount;
								echo"$coursecount";


							echo'</td>
							<td>'.$Available.'</td>
							<td><center>';
							if($Available==0)
							{
								echo'FULL';
							}
							else
							{
								echo'<input type=checkbox name=course[] value='.$coursefetch["id"].'>';
							}


							echo'</td>
						</tr>';
					}
				}
				echo"<tr><td colspan=5><center>
				</td></tr></table>
				<br>
				<input type=hidden name=student value=".$studid.">
				<input type=hidden name=term value=".$sem.">
				<input type=submit name=addsubject value=POST> &nbsp; <a href=index.php buttonlike>Cancel</a>
				</form>";

			}
			else
			{
				header('location:index.php');
			}
		?>
	<br>
</div>
</div>
</body>
</html>
