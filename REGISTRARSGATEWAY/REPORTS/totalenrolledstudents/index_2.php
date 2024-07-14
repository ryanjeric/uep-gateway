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
<a class='spanhead'>Total Enrolled Students</a>
<a href='index.php' class='back'>&#8629 Back</a>
</span>
<br>
<br>
<center>

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

					$prog=mysqli_query("SELECT * FROM programs order by abbreviation") or die(mysqli_error());
					echo'
					<table><tr><td>YEAR : '.$year.'</td></tr>
					<tr><td>SEM : '.$semm.'</td></tr>
					</table>
					';
					echo"<table class='report-table1'>
					<tr head>
						<td>Program</td>
						<td>FEMALE</td>
						<td>MALE</td>
						<td>TOTAL</td>
					</tr>";
					$count=1;
					$totalstudent=0;
					$totalfemale=0;
					$totalmale=0;
							while($progs=mysqli_fetch_array($prog))
							{
										$progid=$progs['id'];

										$malestudent=mysqli_query("SELECT studentstbl.sex from studentstbl inner join studentssubjtbl on studentstbl.idno=studentssubjtbl.studentid where studentstbl.sex='Male' and studentstbl.program=$progid and studentssubjtbl.term=$semid group by studentssubjtbl.studentid");
										$femalestudent=mysqli_query("SELECT studentstbl.sex from studentstbl inner join studentssubjtbl on studentstbl.idno=studentssubjtbl.studentid where studentstbl.sex='Female' and studentstbl.program=$progid and studentssubjtbl.term=$semid group by studentssubjtbl.studentid");

										$mcount=mysqli_num_rows($malestudent);
										$fcount=mysqli_num_rows($femalestudent);

										$tot=$mcount+$fcount;
										echo'
										<tr>
										<td>'.$count++.' '.$progs["abbreviation"].'</td>
										<td>'.$fcount.'</td>
										<td>'.$mcount.'</td>
										<td>'.$tot.'</td>
										</tr>';	
										$totalfemale=$totalfemale+$fcount;
										$totalmale=$totalmale+$mcount;
										$totalstudent=$totalstudent+$tot;
							}
					}
					echo"<tr>
						<td>TOTAL</td>
						<td>".$totalfemale."</td>
						<td>".$totalmale."</td>
						<td>".$totalstudent."</td>
					</tr>
					</table>
					<form action=print.php method=POST target=_blank>
					<input type=hidden name=year value=".$year.">
					<input type=hidden name=sem value=".$semm.">
					<input type=hidden name=semid value=".$semid.">
					</center> <br>
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
			else
			{
				header("Location: index.php");
			}
	?>

</div>
</div>
</body>
</html>