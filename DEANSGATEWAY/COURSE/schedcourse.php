<?php
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
<a href='index.php' class='back'>&#8629 Cancel Creating Schedule</a>
</span>
<br>
<br>
<center>
<?php
$course=mysqli_query("SELECT * FROM coursetbl where id={$_GET['id']}") or die(mysqli_error());


	$coursenumber=mysqli_num_rows($course);

	echo"<table class='simple-style1'>
		<tr head>
			<td colspan='2'>Create Schedule</td> 
		</tr>";
		$courses=mysqli_fetch_array($course);
		$courseid=$courses['id'];
		echo'
				
					<tr><td>TERM: </td><td><u>'.$rows["syear"].' '.$rows["sem"].'</u></td></tr>
					<tr><td>Course Code</td><td>'.$courses["coursecode"].'</td></tr>
					<tr><td>Course description</td><td>'.$courses["coursedesc"].'</td></tr>
					<tr><td>Section</td><td>'.$courses["section"].'</td></tr>
					<tr><td>No.lec</td><td>'.$courses["nolec"].'</td></tr>
					<tr><td>No.lab</td><td>'.$courses["nolab"].'</td></tr>
					<tr><td>Lab Type</td><td>'.$courses["labtype"].'</td></tr>
					<tr><td>Sluts</td><td>'.$courses["slots"].'</td></tr>
					';
		
		?>
	</table>
	<br>
	<form method="POST" action="verifysched.php?id=<?php echo $courseid; ?>">
	<table class='style-schedule'>
		<tr head>
			<td>Type</td>
			<td>Schedule Day</td>
			<td>Start Time</td>
			<td>End Time</td>
			<td>Room</td>
			<td>Instructor</td>
			<td>Remarks</td>
		</tr>


		<?php
		$c=0;
		do
		{
		echo'
			<tr>
				<td>
					<select name="classtype'.$c.'">
						<option value="">--</option>
						<option value="LEC">LEC</option>
						<option value="LAB">LAB</option>
					</select>
				</td>
				<td>
					<input type=checkbox value="M" name="m'.$c.'">M</input>
					<input type=checkbox value="T" name="t'.$c.'">T</input>
					<input type=checkbox value="W" name="w'.$c.'">W</input>
					<input type=checkbox value="TH" name="th'.$c.'">TH</input>
					<input type=checkbox value="F" name="f'.$c.'">F</input>
					<input type=checkbox value="S" name="s'.$c.'">S</input>
				</td>
				<td>
					<input type=number name="strthr'.$c.'"></input>:
					<input type=number name="strtmin'.$c.'"></input>
					<select name="strttypeday'.$c.'">
						<option value="">--</option>
						<option value="AM">AM</option>
						<option value="PM">PM</option>
					</select>
				</td>
				<td>
					<input type=number name="endhr'.$c.'"></input>:
					<input type=number name="endmin'.$c.'"></input>
					<select name="endtypeday'.$c.'">
						<option value="">--</option>
						<option value="AM">AM</option>
						<option value="PM">PM</option>
					</select>
				</td>
				<td><select name="Room'.$c.'">
					<option value="0">--</option>
				';
					$rooms=mysqli_query("SELECT * from roomstbl order by ctr") or die(mysqli_error());

					while($roomsz=mysqli_fetch_array($rooms))
					{

							echo"<option value=".$roomsz['ctr'].">".$roomsz['roomname']."/".$roomsz['type']."</option>";
					}

				echo'
				</select>
				</td>
				<td>
					<select name="instructor'.$c.'">
						<option value="0">--</option>';

						
						$instructor=mysqli_query("SELECT * FROM staff where status='ACTIVATE'") or die(mysqli_error());

						while($ins=mysqli_fetch_array($instructor))
						{

							echo"<option value=".$ins['ctr'].">".$ins['lname'].",".$ins['gname']."</option>";
						}


						echo'
					</select>
				</td>

				<td>
					<textarea name="remarks'.$c.'"></textarea>
				</td>
			</tr>';
		$c++;
		}
		while($c<5);
		?>
		<tr foot>
			<td colspan='7'><input type="submit" name="step2" value="GO TO STEP 2">
			&nbsp;
			<a href="index.php" buttonlike>Cancel</a></td>
	</table>
</form>
<br>
	<div style="float:left;margin-left:200px;">
	</div>
</div>
</div>
</body>
</html>
