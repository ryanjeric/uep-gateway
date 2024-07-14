<?php
ob_start();
session_start();
include('conn.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php require "../list-table-css.txt"; ?>
</style>
</head>
<body>
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
<br>
<center>
<br>
<?php
		$instructor=$_GET["id"];
		$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
		$insz=mysqli_fetch_array($insquery);
	print "<table class='simple-style1-print'>
			<tr>
				<td>Name:</td>
				<td>$insz[lname], $insz[gname]</td>
			</tr>
			<tr>
				<td>Designation:</td>
				<td>$insz[designation]</td>
			</tr>
			</table>";

		$checksched=mysqli_query("SELECT * FROM schedule where instructor=".$_GET['id']." and term=$sem GROUP BY courseid") or die(mysqli_error());
		$totalclass=mysqli_num_rows($checksched);
?>
<br>
	<table class='style-schedule-print'>
		<tr>	
			<td colspan='10'><b>TOTAL CLASS : <?php echo ''.$totalclass.'</b>'; ?><br></td>
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
					
		</tr>
		<?php
				
					
					while($schedz=mysqli_fetch_array($checksched))
					{
						$subj=$schedz['courseid'];
						$coursequery=mysqli_query("SELECT * FROM coursetbl where id=$subj") or die(mysqli_error());
						$coursefetch=mysqli_fetch_array($coursequery);
						
								$course=$coursefetch['id'];
								$courselec=$coursefetch['nolec'];
								$courselab=$coursefetch['nolab'];
								$courseunits=0;
								$courseunits=$courselec+$courselab;
								$schedquery=mysqli_query("SELECT * FROM schedule where term=$sem and courseid=$course and instructor=".$_GET['id']."") or die(mysqli_error());
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

																if($schedfetch["endmin"] == 0) { $endmin = "00";}
																else {$endmin = $schedfetch["endmin"];}

																if($schedfetch["startmin"] == 0) { $startmin = "00";}
																else {$startmin = $schedfetch["startmin"];}

																echo'|'.$schedfetch["starthr"].':'.$startmin.' '.$schedfetch["starttypeday"].'
																to '.$schedfetch["endhr"].':'.$endmin.' '.$schedfetch["endtypeday"].' |';

																$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$roomid") or die(mysqli_error());
																$roomfetch=mysqli_fetch_array($roomquery);
																echo "".$roomfetch['roomname']."/".$roomfetch['type']." ";

																$instructor=mysqli_query("SELECT * FROM staff where ctr=$insid") or die(mysqli_error());
																$insfetch=mysqli_fetch_array($instructor);
																echo'<br>'.$insfetch['lname'].','.$insfetch['gname'].';<br>';
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
										


													</tr>';		
												}
					}

		?>
	</table>
<br>
	<div style="float:left;margin-left:200px;">
	</div>
</div>
</div>
</body>
</html>