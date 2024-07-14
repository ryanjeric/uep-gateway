<?php
include('conn.php');
session_start();
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
<div warp>
<div d2>
<br>
<br>
<center>
<?php
$course=mysqli_query("SELECT * FROM coursetbl where id={$_GET['id']}") or die(mysqli_error());


	$coursenumber=mysqli_num_rows($course);

	echo"<table class='simple-style1-print'>
		<tr head>
			<td colspan='2'>COURSE SCHEDULE</td> 
		</tr>";
		$courses=mysqli_fetch_array($course);
		$courseid=$courses["id"];
		echo'
				
					<tr><td>Term:</td><td> <u>'.$rows["syear"].' '.$rows["sem"].'</u></td></tr>
					<tr><td>Course Code</td><td>'.$courses["coursecode"].'</td></tr>
					<tr><td>Course description</td><td>'.$courses["coursedesc"].'</td></tr>
					<tr><td>Section</td><td>'.$courses["section"].'</td></tr>
					<tr><td>No.lec</td><td>'.$courses["nolec"].'</td></tr>
					<tr><td>No.lab</td><td>'.$courses["nolab"].'</td></tr>
					<tr><td>Lab Type</td><td>'.$courses["labtype"].'</td></tr>
					<tr><td>Slots</td><td>'.$courses["slots"].'</td></tr>
					';

		?>
	</table>

	<br><span section>Schedule</span>

	<table class='style-schedule-print'>
		<tr head>
			<td style="max-width:80px;font-size:16px">Type</td>
			<td style="max-width:80px;font-size:16px">Schedule Day</td>
			<td style="max-width:80px;font-size:16px">Start Time</td>
			<td style="max-width:80px;font-size:16px">End Time</td>
			<td style="max-width:80px;font-size:16px">Room</td>
			<td style="max-width:120px;font-size:16px">Instructor</td>
			<td style="max-width:80px;font-size:16px">Remarks
			</td>
		</tr>
		<?php
				
					
					$checksched=mysqli_query("SELECT * FROM schedule where courseid=".$courses['id']." and term=$sem order by mynumber") or die(mysqli_error());
					while($schedz=mysqli_fetch_array($checksched))
					{
						echo'<tr>
								<td>'.$schedz["classtype"].'</td>
								<td>';
								if($schedz['m']==1)
								{
									echo'M ';
								}
								if($schedz['t']==1)
								{
									echo'T ';
								}
								if($schedz['w']==1)
								{
									echo'W ';
								}
								if($schedz['th']==1)
								{
									echo'TH ';
								}
								if($schedz['f']==1)
								{
									echo'F ';
								}
								if($schedz['s']==1)
								{
									echo'S ';
								}

								if($schedz["endmin"] == 0) { $endmin = "00";}
                                else {$endmin = $schedz["endmin"];}

                                if($schedz["startmin"] == 0) { $startmin = "00";}
                                else {$startmin = $schedz["startmin"];}

								echo'</td>
								<td>'.$schedz["starthr"].':'.$startmin.' '.$schedz["starttypeday"].'</td>
								<td>'.$schedz["endhr"].':'.$endmin.' '.$schedz["endtypeday"].'</td>
								<td>';
													$rmz=$schedz["room"];
													$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$rmz");
													$r=mysqli_fetch_array($roomquery);
													echo"".$r['roomname']."/".$r['type']."";

								echo'</td>
								<td>';
													$instructor=$schedz["instructor"];
													$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
													$insz=mysqli_fetch_array($insquery);
													echo"".$insz['lname'].",".$insz['gname']."";

								echo'</td>
								<td>'.$schedz["remarks"].'</td>
							</tr>
						';
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