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
if (!isset($_SESSION['id2'])){
header('location:../index.php');
}
if(!isset($_SESSION['sem3']))
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
<?php
include "info.php";
?>

<div d2>
<span class='divhead'>
<a class='spanhead'>Courses</a>
<a href='../registrarshome.php' class='back'>&#8629 Back to Home</a>
</span>
<br>
<br>
<center>
<?php
$course=mysqli_query("SELECT * FROM coursetbl order by id") or die(mysqli_error());


	$coursenumber=mysqli_num_rows($course);

	echo"<table class='list2'>
		<tr>
			<td colspan='9'>No. of Courses : $coursenumber
				<a href='addcourse.php' class='new-or-add'>+Add Course</a></td>
		</tr>
		<tr>
			<td>ctr</td>
			<td>Course Code</td>
			<td>Course description</td>
			<td>Section</td>
			<td>No.lec</td>
			<td>No.lab</td>
			<td>Lab Type</td>
			<td>Slots</td>
			<td width=120px>Action</td>
		</tr>";
		$c=1;
		while($courses=mysqli_fetch_array($course))
		{
		echo'
				<tr>
					<td>'.$c++.'</td>
					<td>'.$courses["coursecode"].'</td>
					<td>'.$courses["coursedesc"].'</td>
					<td>'.$courses["section"].'</td>
					<td>'.$courses["nolec"].'</td>
					<td>'.$courses["nolab"].'</td>
					<td>'.$courses["labtype"].'</td>
					<td>'.$courses["slots"].'</td>
					<td>';
					?>

					<?php 
					 $check=mysqli_query("SELECT * From studentssubjtbl where courseid=".$courses['id']."");
					 $count=mysqli_num_rows($check);

					 if($count==0)	{

					 
					?>

					<form method="POST" action="editcourse.php?id=<?php echo''.$courses["id"].''; ?>">
					<input type="submit" value="Edit" name="editcourse" style='float:left'></form>
					
					<!-- Condition for disabled delete here -->
					<form method=POST action="deletecourse.php?id=<?php echo''.$courses["id"].''; ?>">
					&nbsp; <span onclick="return confirm('Are you sure you want to delete this Course?')"><input type="submit" value="Delete" name="delcourse"></form></span></td>
				

					<?php
									 }
					else
					{
						?>
					<form method="POST" action="editcourse.php?id=<?php echo''.$courses["id"].''; ?>">
					<input type="submit" value="Edit" name="editcourse" >
					</form>
					<form method="POST" action="grades.php?id=<?php echo''.$courses["id"].''; ?>">
					<input type="submit" value="View Grades" name="viewgrades" >
					</form>
					<?php
					}

					?>


				<?php echo'</tr>';
		}
		?>


	</table><br>
	<div style="float:left;margin-left:200px;">


	</div>
</div>
</div>
</body>
</html>