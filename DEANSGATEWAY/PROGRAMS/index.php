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
<?php
include "info.php";
?>

<div d2>
<span class='divhead'>
<a class='spanhead'>Programs</a>
<a href='../deanshome.php' class='back'>&#8629 Back to Home</a>
</span>
<br>
<br>
<center>
<?php
$prog=mysqli_query("SELECT * FROM programs order by id") or die(mysqli_error());


	$prognumber=mysqli_num_rows($prog);

	echo"<table class='list2'>
		<tr>
			<td colspan='4'>No. of Programs : $prognumber
				<a href='addprog.php' class='new-or-add'>+Add Program</a></td>
		</tr>
		<tr>
			<td>ctr</td>
			<td>Program Description</td>
			<td>Abbreviation</td>
			<td>Action</td>
		</tr>";
		$count=1;
		while($progs=mysqli_fetch_array($prog))
		{
		echo'
				<tr>
					<td>'.$count++.'</td>
					<td>'.$progs["programdesc"].'</td>
					<td>'.$progs["abbreviation"].'</td>
					<td width=150px>';

					$progz=mysqli_query("SELECT * FROM studentstbl where program=".$progs['id']."") or die(mysqli_error());
					$progscount=mysqli_num_rows($progz);

					if($progscount==0)
					{


					?>
					<form method="POST" action="editprog.php?id=<?php echo''.$progs["id"].''; ?>">
					<input type="submit" value="Edit" name="editprog" style='float:left; margin-right:5px;'></form> 
					<form method=POST action="deleteprog.php?id=<?php echo''.$progs["id"].''; ?>">
					<span onclick="return confirm('Are you sure you want to delete this Program?')"><input type="submit" value="Delete" name="delprog" style='float:left'></form></span></td>
<?php 
					}
					else
					{
						?>
					<form method="POST" action="editprog.php?id=<?php echo''.$progs["id"].''; ?>">
					<input type="submit" value="Edit" name="editprog"></form>
						<?php
					}


				echo'</tr>';
		}
?>


	</table><br>
	<div style="float:left;margin-left:200px;">


	</div>
</div>
</div>
</body>
</html>