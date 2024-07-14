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
<a class='spanhead'>Courses</a>
<a href='../deanshome.php' class='back'>&#8629 Back to Home</a>
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
				</td>
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
			<td>Action</td>
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
$checksched=mysqli_query("SELECT * FROM schedule where courseid=".$courses['id']." and term=$sem") or die(mysqli_error());
$count=mysqli_num_rows($checksched);


if($count>0)
{
	?>
	<form method="POST" action="viewsched.php?id=<?php echo''.$courses["id"].''; ?>">
					<input type="submit" value="View Schedule" name="viewsched" >
	</form>
	<?php
}
else
{
?>
	<form method="POST" action="schedcourse.php?id=<?php echo''.$courses["id"].''; ?>">
					<input type="submit" value="Set Schedule" name="editcourse">
	</form>
<?php
}
?>
			</td>
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