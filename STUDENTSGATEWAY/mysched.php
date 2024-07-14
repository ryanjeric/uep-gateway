<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Student's Gateway</title>
<script src='jquery.min.js'></script>
<style>
<?php 
	require "frame-css.txt"; 
	require "list-table-css.txt";
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
if (!isset($_SESSION['id3'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem2']))
{
header('location:../chooseterm.php');
}
?>
<?php
	$idno=$_SESSION['id3'];
	$sem=$_SESSION['sem2'];
	$res=mysqli_query("SELECT * FROM studentstbl where idno=$idno") or die(mysqli_error());
	$row=mysqli_fetch_array($res);
	$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
	$rows=mysqli_fetch_array($ress);
?>
<div warp>
	<?php include "info.php"; ?>
<div d2>
<span class='divhead'>
<a class='spanhead'>My Schedule</a>
<a href='studenthome.php' class='back' title='Back to Home' >&#8629 Back to Home</a>
</span>
<center><br>
	<?php
				$studquery=mysqli_query("SELECT * FROM studentstbl where idno=$idno") or die(mysqli_error());
				$studfetch=mysqli_fetch_array($studquery);
				echo"<table class='simple-style1'>
				<tr><td>Year Term:</td><td>".$rows['syear']."</td></tr>
				<tr><td>ID No.:</td><td>".$studfetch['idno']."</td></tr>
				<tr><td>Student Name:</td><td>".$studfetch['lname'].", ".$studfetch['gname']."</td></tr>
				<tr><td>Program: </td><td>";
								$progquery=mysqli_query("SELECT abbreviation from programs where id=".$studfetch['program']."") or die(mysqli_error());
								$progfetch=mysqli_fetch_array($progquery);
								echo''.$progfetch['abbreviation'].'';
				echo"</td></tr>
				<tr><td>Admission: </td><td>".$studfetch['yearofadmission']."</td>
				</table><br>STUDENT SUBJECTS";

				echo"<table class='style-schedule1'>
							<tr head>
							<td width=80px>Course ID</td>
							<td>CourseCode</td>
							<td>CourseDesciption</td>
							<td>Section</td>
							<td>Units</td>
							<td>Schedule</td>
							</tr>";
				$mysubject=mysqli_query("SELECT * FROM studentssubjtbl where studentid=$idno and term=$sem") or die(mysqli_error());
				$countsubj=mysqli_num_rows($mysubject);

				if($countsubj==0)
				{
					echo'<tr><td colspan=10>No Subjects yet</td></tr>';
				}
				else
				{
				while($fetchsubject=mysqli_fetch_array($mysubject))
				{
					$subj=$fetchsubject['courseid'];
					$coursequery=mysqli_query("SELECT * FROM coursetbl where id=$subj") or die(mysqli_error());
					$coursefetch=mysqli_fetch_array($coursequery);
						
								$course=$coursefetch['id'];
								$courselec=$coursefetch['nolec'];
								$courselab=$coursefetch['nolab'];
								$courseunits=0;
								$courseunits=$courselec+$courselab;
								$schedquery=mysqli_query("SELECT * FROM schedule where term=$sem and courseid=$course") or die(mysqli_error());
											$schedCount=mysqli_num_rows($schedquery);
											if($schedCount==0)
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
																echo "".$roomfetch['roomname']."/".$roomfetch['type']."";

																$instructor=mysqli_query("SELECT * FROM staff where ctr=$insid") or die(mysqli_error());
																$insfetch=mysqli_fetch_array($instructor);
																echo'<br>'.$insfetch['lname'].', '.$insfetch['gname'].';<br>';
															}
														
													echo'</td></tr>';

											}
						
				}
				}
				echo"</table><br><a href=myschedprint.php target=_blank buttonlike>Print Preview</a>";

			
		?>

<br><br>
</div>
</div>
</body>
</html>