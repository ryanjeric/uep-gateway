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
<?php 
require "../../frame-css.txt"; 
require "../../list-table-css.txt";
?>

</style>
<script>
function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML = h+":"+m+":"+s;
    var t = setTimeout(function(){startTime()},500);
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>

</head>
<body onload="startTime()">
<?php
if (!isset($_SESSION['id2'])){
header('location:../../index.php');
}
if(!isset($_SESSION['sem3']))
{
header('location:../../chooseterm.php');
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
<?php
include "info.php";
?>

<div d2>
<span class='divhead'>
<a class='spanhead'>Schedule of Classes</a>
<a href='index.php' class='back'>&#8629 Back</a>
</span>
<br>
<br>

	<div>
	<?php
			if(isset($_POST['submit']))
			{
					$year=$_POST['year'];
					$semm=$_POST['sem'];

					$semyr=mysqli_query("SELECT * FROM semtbl where syear='$year' and sem='$semm'");
					$checksem=mysqli_num_rows($semyr);
					$semf=mysqli_fetch_array($semyr);
					if($checksem==0)
					{
						echo'<script type="text/javascript">alert("TERM NOT EXIST");</script>';
						echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
					}
					else
					{
					$semid=$semf['id'];
					$c=1;
					$schedule=mysqli_query("SELECT schedule.courseid FROM schedule inner join coursetbl on schedule.courseid=coursetbl.id where schedule.term=$semid GROUP BY schedule.courseid order by coursetbl.coursedesc");
					$totalclass=mysqli_num_rows($schedule);
					if($totalclass==0)
					{
						echo'<script type="text/javascript">alert("NO FOUND SCHEDULE IN THIS TERM");</script>';
						echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
					}
					echo'
					<span tenpercent>
					<b>YEAR : </b>'.$year.' <br>
					<b>SEM : </b>'.$semm.'
					</span>
					<br><br>
					';
					echo"<table class='report-table1'><tr head><td>COUNT</td><td>SubjectCode</td><td>SubjectDescription</td><td>Section</td><td>Schedule</td></tr>";
						while($schedfetch=mysqli_fetch_array($schedule))
						{
							$subj=$schedfetch['courseid'];

							$coursequery=mysqli_query("SELECT * FROM coursetbl where id=$subj") or die(mysqli_error());
							$coursefetch=mysqli_fetch_array($coursequery);
							
							$course=$coursefetch['id'];

							echo"<tr>
								<td>".$c++."</td>
								<td>".$coursefetch['coursecode']."</td>
								<td>".$coursefetch['coursedesc']."</td>
								<td>".$coursefetch['section']."</td>
								<td>";

							$schedquery=mysqli_query("SELECT * FROM schedule where term=$semid and courseid=$course") or die(mysqli_error());
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
																echo "".$roomfetch['roomname']."/".$roomfetch['type']." ";

																$instructor=mysqli_query("SELECT * FROM staff where ctr=$insid") or die(mysqli_error());
																$insfetch=mysqli_fetch_array($instructor);
																echo'<br>'.$insfetch['lname'].','.$insfetch['gname'].';<br>';
															}


						}





					echo"<tr><td colspan=5>NO.of Classes :".$totalclass."</td></tr>
					</table>
					<span tenpercent>
					<form action=print.php method=POST target=_blank>
					<input type=hidden name=year value=".$year.">
					<input type=hidden name=sem value=".$semm.">
					<input type=hidden name=semid value=".$semid.">
					<a href='../../registrarshome.php' buttonlike>HOME</a>
					<input type=submit name=print value=PRINT>
					<a href='../index.php' buttonlike>REPORTS</a>
					</form>
					</span><br><br>";
			}
		}
			else
			{
				header("Location: index.php");
			}
	?>

</div>
</div>
</body>
</html>