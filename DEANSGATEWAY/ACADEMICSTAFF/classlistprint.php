<?php
ob_start();
session_start();
include('../conn.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php  
require "../list-table-css.txt";
?>
</style>
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
<div d2>
<span class='divhead'>
	<?php
		if(isset($_POST['classlist']))
		{
			$course=$_POST['courseid'];
			$ins=$_POST['ins'];
			$classlist=mysqli_query("SELECT * FROM schedule where term=$sem and courseid=$course Group by courseid") or die(mysqli_error());
			$fetchclass=mysqli_fetch_array($classlist);

			$classlistz=mysqli_query("SELECT * FROM studentssubjtbl where term=$sem and courseid=$course") or die(mysqli_error());
			$countclass=mysqli_num_rows($classlistz);

			$subj=$fetchclass['courseid'];
			$coursequery=mysqli_query("SELECT * FROM coursetbl where id=$subj") or die(mysqli_error());
			$coursefetch=mysqli_fetch_array($coursequery);

			echo"
				</span>
				<br>
				<br>
				<center>
				<br>";


			echo'CLASS LIST<br>
			<table class="simple-style1-print">
					<tr><td>CourseCode :</td><td>'.$coursefetch["coursecode"].'</td></tr>
					<tr><td>Course Description :</td><td>'.$coursefetch["coursedesc"].'</td></tr>
					<tr><td>Section :</td><td>'.$coursefetch["section"].'</td></tr>
					<tr><td>Schedule :</td><td>';
						$sched=mysqli_query("SELECT * FROM schedule where term=$sem and courseid=$course") or die(mysqli_error());
						while($schedfetch=mysqli_fetch_array($sched))
															{
																$roomid=$schedfetch["room"];
																$insid=$schedfetch["instructor"];
																echo'|'.$schedfetch["classtype"].'|';

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
																echo''.$insfetch['lname'].','.$insfetch['gname'].';<br>';
															}
					echo'</td></tr>
				<tr><td>No of Student :</td><td>'.$countclass.'</td></tr>
			</table><br>';

			echo'<table class="list3-print">
					<tr head>
						<td>COUNT</td>
						<td>STUDENT ID#</td>
						<td>Lastname</td>
						<td>GivenName</td>
						<td>Program</td>
					</tr>
				';
			$students=mysqli_query("SELECT * FROM studentssubjtbl where courseid=$course and term=$sem") or die(mysqli_error());
			$num=0;
			while($studfetch=mysqli_fetch_array($students))
			{
				$number=1+$num;
				$studid=$studfetch['studentid'];
				echo'<tr>
							<td>'.$number.'</td>
							<td>'.$studid.'</td>
							<td>';
								$studname=mysqli_query("SELECT * FROM studentstbl where idno=$studid");
								$studnamefetch=mysqli_fetch_array($studname);
								$Program=$studnamefetch['program'];
								$prog=mysqli_query("SELECT abbreviation From programs where id=$Program");
								$progfetch=mysqli_fetch_array($prog);

							echo''.$studnamefetch['lname'].'';
							echo'</td><td>'.$studnamefetch['gname'].'</td><td>'.$progfetch['abbreviation'].'</td>';



				echo'</tr>
						<tr><td colspan="5" style="height:5px;background:#ddd;"></td></tr>';echo'</tr>';
				$num++;
			}
			
			echo'</table>';

		}
		else
		{
			header("Location:index.php");
		}

?>
<br>
	<div style="float:left;margin-left:200px;">
	</div>
</div>
</div>
</body>
</html>