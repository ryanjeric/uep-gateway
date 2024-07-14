<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Registrar's Gateway</title>
<style>
<?php require "../list-table-css.txt"; ?>
</style>
</head>
<body>
<?php
if (!isset($_SESSION['id2'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:../chooseterm.php');
}
?>
<?php
	$id=$_SESSION['id2'];
	$sem=$_SESSION['sem3'];
	$res=mysqli_query("SELECT * FROM registrar where ctr=$id") or die(mysqli_error());
	$row=mysqli_fetch_array($res);
	$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
	$rows=mysqli_fetch_array($ress);
?>
<div warp>
<div d2>
<br>
<br>
<center>
	<?php

				$studid=$_GET['id'];
				$studquery=mysqli_query("SELECT * FROM studentstbl where idno=$studid") or die(mysqli_error());
				$studfetch=mysqli_fetch_array($studquery);
				echo"<table class='simple-style1-print'>
				<tr><td>Year Term:</td><td>".$rows['syear']."</td></tr>
				<tr><td>ID No.:</td><td>".$studfetch['idno']."</td></tr>
				<tr><td>Student Name:</td><td>".$studfetch['lname'].", ".$studfetch['gname']."</td></tr>
				<tr><td>Program : </td><td>";
								$progquery=mysqli_query("SELECT abbreviation from programs where id=".$studfetch['program']."") or die(mysqli_error());
								$progfetch=mysqli_fetch_array($progquery);
								echo''.$progfetch['abbreviation'].'';
				echo"</td></tr>
				<tr><td>Admission : </td><td>".$studfetch['yearofadmission']."</td>
				</table><br>";

				echo"<table class='style-schedule-print'>
							<tr head>
							<td width='80px'>Course ID</td>
							<td>CourseCode</td>
							<td>CourseDesciption</td>
							<td>Section</td>
							<td>Units</td>
							<td>Schedule</td>
							<td>Slots</td>
							<td>#listed</td>
							<td>Available</td>
							</tr>";
				$mysubject=mysqli_query("SELECT * FROM studentssubjtbl where studentid=$studid and term=$sem") or die(mysqli_error());
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

																echo'|'.$schedfetch["starthr"].':'.$startmin.' '.$schedfetch["starttypeday"].'
																to '.$schedfetch["endhr"].':'.$endmin.' '.$schedfetch["endtypeday"].' |';

																$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$roomid") or die(mysqli_error());
																$roomfetch=mysqli_fetch_array($roomquery);
																echo "".$roomfetch['roomname']."/".$roomfetch['type']."";

																$instructor=mysqli_query("SELECT * FROM staff where ctr=$insid") or die(mysqli_error());
																$insfetch=mysqli_fetch_array($instructor);
																echo'<br>'.$insfetch['lname'].', '.$insfetch['gname'].';<br>';
															}
									
													echo'</td>
													<td>'.$coursefetch["slots"].'</td>
													<td>';

									$coursezquery=mysqli_query("SELECT * FROM studentssubjtbl where courseid=$course and term=$sem") or die(mysqli_error());
														$coursezcount=mysqli_num_rows($coursezquery);
														$slotz=$coursefetch["slots"];
														$Available=$slotz-$coursezcount;
														echo"$coursezcount";

													echo'</td>
													<td>'.$Available.'</td>
													'; 
		?>
												</tr>
		<?php
											}
						
				}
				}
				echo"</table><br>";

			
		?>
	<br>
</div>
</div>
</body>
</html>
