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
<a href='index.php' class='back'>&#8629 Cancel</a>
</span>
<br>
<br>
<center>
<?php
$course=mysqli_query("SELECT * FROM coursetbl where id={$_GET['id']}") or die(mysqli_error());


	$coursenumber=mysqli_num_rows($course);

	echo"<table class='simple-style1'>
		<tr head>
			<td colspan='2'>UPDATE SCHEDULE</td> 
		</tr>";
		$courses=mysqli_fetch_array($course);
		$courseid=$courses['id'];
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
	</table><br><br>
	<form method="POST" action="updatesched.php">
	<table class='style-schedule'>
		<tr head>
			<td>Type</td>
			<td>Schedule Day</td>
			<td>Start Time</td>
			<td>End Time</td>
			<td>Room</td>
			<td>Instructor</td>
			<td>Remarks
					<input type=hidden name=term value='<?php echo $sem; ?>'>
					<input type=hidden name=courseid value='<?php echo $courseid; ?>'>
			</td>

		</tr>


		<?php
		if(isset($_POST['editsched']))
		{

			$editsched=mysqli_query("SELECT * FROM schedule where courseid=$courseid and term=$sem order by mynumber");
			$countsched=mysqli_num_rows($editsched);
			while($editfetch=mysqli_fetch_array($editsched))
			{
				echo'
			<tr>
				<td>
					<select name="classtype'.$editfetch['mynumber'].'">';
				?>
						<option value="wew">--</option>
						<option value="LEC" <?php if($editfetch['classtype']=='LEC'){echo'selected';} ?>>LEC</option>
						<option value="LAB" <?php if($editfetch['classtype']=='LAB'){echo'selected';} ?>>LAB</option>

				<?php		
					echo'</select>
				</td>';
				?>
				<td>
					<input type=checkbox value="M" name=M<?php echo''.$editfetch['mynumber'].''; ?> 
					<?php echo ($editfetch['m']==1 ? 'checked' : '');?>>M</input>
					<input type=checkbox value="T" name=T<?php echo''.$editfetch['mynumber'].''; ?>
					<?php echo ($editfetch['t']==1 ? 'checked' : '');?>>T</input>
					<input type=checkbox value="W" name=W<?php echo''.$editfetch['mynumber'].''; ?>
					<?php echo ($editfetch['w']==1 ? 'checked' : '');?>>W</input>
					<input type=checkbox value="TH" name=TH<?php echo''.$editfetch['mynumber'].''; ?>
					<?php echo ($editfetch['th']==1 ? 'checked' : '');?>>TH</input>
					<input type=checkbox value="F" name=F<?php echo''.$editfetch['mynumber'].''; ?>
					<?php echo ($editfetch['f']==1 ? 'checked' : '');?>>F</input>
					<input type=checkbox value="S" name=S<?php echo''.$editfetch['mynumber'].''; ?>
					<?php echo ($editfetch['s']==1 ? 'checked' : '');?>>S</input>
				</td>
				<?php
				echo'<td>
					<input type=number name="strthr'.$editfetch['mynumber'].'" 
					value="'.$editfetch['starthr'].'"></input>:
					<input type=number name="strtmin'.$editfetch['mynumber'].'" 
					value="'.$editfetch['startmin'].'"></input>
					<select name="strttypeday'.$editfetch['mynumber'].'" >';
				?>
						<option value="AM" <?php echo ($editfetch['starttypeday']=='AM' ? 'selected' : '');?>>AM</option>
						<option value="PM" <?php echo ($editfetch['starttypeday']=='PM' ? 'selected' : '');?>>PM</option>
				
				<?php
				echo'
					</select>
				</td>
				<td>
					<input type=number name="endhr'.$editfetch['mynumber'].'"
					value="'.$editfetch['endhr'].'"></input>:
					<input type=number name="endmin'.$editfetch['mynumber'].'"
					value="'.$editfetch['endmin'].'"></input>:
					<select name="endtypeday'.$editfetch['mynumber'].'">';
				?>

						<option value="AM" <?php echo ($editfetch['endtypeday']=='AM' ? 'selected' : '');?>>AM</option>
						<option value="PM" <?php echo ($editfetch['endtypeday']=='PM' ? 'selected' : '');?>>PM</option>
				<?php
				echo'
					</select>
				</td>
				<td><select name="Room'.$editfetch['mynumber'].'">
					<option value="0">--</option>
				';
					$rooms=mysqli_query("SELECT * from roomstbl order by ctr") or die(mysqli_error());

					while($roomsz=mysqli_fetch_array($rooms))
					{

							echo"<option value=".$roomsz['ctr']."";
							echo ($editfetch['room']==$roomsz['ctr'] ? ' selected' :'');
							echo">".$roomsz['roomname']."/".$roomsz['type']."</option>";
					}

				echo'
				</select>
				</td>
				<td>
					<select name="instructor'.$editfetch['mynumber'].'">
						<option value="0">--</option>';

						
						$instructor=mysqli_query("SELECT * FROM staff where status='ACTIVATE'") or die(mysqli_error());

						while($ins=mysqli_fetch_array($instructor))
						{

							echo"<option value=".$ins['ctr']."";
							echo ($editfetch['instructor']==$ins['ctr'] ? ' selected' :'');
							echo">".$ins['lname'].",".$ins['gname']."</option>";
						}


						echo'
					</select>
				</td>

				<td>
					<textarea name="remarks'.$editfetch['mynumber'].'">'.$editfetch['remarks'].'</textarea>
				</td>
			</tr>';	
			}

/**
	WHY DO MENS HAVE NIPPLES?		
*/
		}
		else
		{
			header("Location: index.php");
		}
?>
		<tr foot>
			<td colspan='7'><input type="submit" name="updatesched" value="Update Now">
			<a href="index.php" buttonlike>Cancel</a>
		</tr>




	</table>
</form>
<br>
	<div style="float:left;margin-left:200px;">
	</div>
</div>
</div>
</body>
</html>