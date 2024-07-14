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
if (!isset($_SESSION['id'])){
header('location:../../index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:../../chooseterm.php');
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

	<div>
	<?php
			if(isset($_POST['print']))
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
					<table><tr><td><b>YEAR :</b> '.$year.'</td></tr>
					<tr><td><b>SEM : </b>'.$semm.'</td></tr>
					</table><br>
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
					</tr>";
		}
			else
			{
				header("Location: index.php");
			}
	?>

</div>
</body>
</html>