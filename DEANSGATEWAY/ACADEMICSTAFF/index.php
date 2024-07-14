<?php
error_reporting(0);
ob_start();
session_start();
include('conn.php');
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
<script src='../jquery.js'></script>
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
<a class='spanhead'>ACADEMIC STAFF</a>
<a href='../deanshome.php' class='back'>&#8629 Back to Home</a>
</span>
<br>
<br>
<center>
<?php
$staff=mysqli_query("SELECT * FROM staff WHERE empid LIKE '%$_POST[search]%' OR lname LIKE '%$_POST[search]%' ORDER BY lname") or die(mysqli_error());
	$stf=mysqli_num_rows($staff);

	echo"<table class='list4-INS' width='95%'><form method='POST'>
		<tr head>
			<td colspan='2'>No. of Staff : $stf</td>
			<td colspan='6' align='center'>Employee ID/Last Name<input type='text' name='search' search><input type='submit' name='btn_search' value='Search'/></td>
			<td><a href='addstaff.php' class='new-or-add'>+ Add Account</a></td>
		</tr>
		<tr head>
			<td width=40px>ctr</td>
			<td width=100px>EmpNo</td>
			<td width=150px>Lastname</td>
			<td width=150px>GivenName</td>
			<td width=110px>Designation</td>
			<td width=200px>Department</td>
			<td width=100px>NoOfClasses</td>
			<td width=108px>Load</td>
			<td>Action</td>
		</tr></table></form>
		<div style='max-height:300px; width:95%; overflow:scroll;'>
		<table class='list4-INS' width='100%'>";
		$num=0;
		while($s=mysqli_fetch_array($staff))
		{
		$number=1+$num;
		echo'
				<tr>
					<td width=40px>'.$number.'</td>
					<td width=100px>'.$s["empid"].'</td>
					<td width=150px>'.$s["lname"].'</td>
					<td width=150px>'.$s["gname"].'</td>
					<td width=110px>'.$s["designation"].'</td>
					<td width=200px>'.$s["department"].'</td>
					<td width=100px>';
								$ins=$s["ctr"];
								$class=mysqli_query("SELECT * FROM schedule where term=$sem and Instructor=$ins GROUP by COURSEID");
								$countclass=mysqli_num_rows($class);
								echo $countclass;
					echo'</td>
					<td width=108px>'; 

								if($countclass==0)
								{
									echo "_/_";
								}
								else
								{
					?>
							<form method="POST" action="showsched.php?id=<?php echo''.$s["ctr"].''; ?>">
							<input type="submit" value="View Schedule" name="showsched"></form>
					<?php
								}
					echo'</td>
					<td>';
					?><form method="POST" action="editstaff.php?id=<?php echo''.$s["ctr"].''; ?>">
					<input type="submit" value="Edit" name="editstaff" style='float:left;'></form>
					
					<?php
					if ($s["status"]=="DEACTIVATE")
					{
					?>
					<form method=POST action="Activatestaff.php?id=<?php echo''.$s["ctr"].''; ?>">
					<span onclick="return confirm('Are you sure you want to Activate this Instructor?')"><input type="hidden" name="id" value="<?php echo''.$s["ctr"].''; ?>" /><input type="submit" value="Activate" name="activate" style='float:left;'></form></span>
					<?php } 
					else if($s["status"]=="ACTIVATE")
					{
					?>
					<form method=POST action="Deactivatestaff.php?id=<?php echo''.$s["ctr"].''; ?>">
					<span onclick="return confirm('Are you sure you want to Deactivate this Instructor?')"><input type="hidden" name="id" value="<?php echo''.$s["ctr"].''; ?>" /><input type="submit" value="Deactivate" name="deactivate" style='float:left;'></form></span>
					<?php }

					$checksched=mysqli_query("SELECT * FROM SCHEDULE where instructor=$ins");
					$checkcount=mysqli_num_rows($checksched);
					
					if($checkcount==0)
					{
					?>
					<form method=POST action="Deletestaff.php?id=<?php echo''.$s["ctr"].''; ?>">
					<span onclick="return confirm('Are you sure you want to Delete this Instructor?')"><input type="hidden" name="id" value="<?php echo''.$s["ctr"].''; ?>" /><input type="submit" value="Delete" name="delete"></form></span>
					<?php }
					else
					{
					}
					?>
					
					
		
					</td>
				<?php echo'</tr>';
				$num++;
		}
		?>


	</table></div><br>
	<div style="float:left;margin-left:200px;">


	</div>
</div>
</div>
</body>
</html>
<?php
if(isset($_POST['btn_search'])) {
	$search = $_POST['search'];
	?>
	<script>
		$(document).ready(function() {
			$('input[search]').val('<?php echo $search;?>');
		});
	</script>
	<?php
}
?>