<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>UEP - SUPERADMIN</title>
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
if (!isset($_SESSION['super_id'])){
header('location:../index.php');
}
if(!isset($_SESSION['super_sem']))
{
header('location:../chooseterm.php');
}
?>
<?php
$id=$_SESSION['super_id'];
$sem=$_SESSION['super_sem'];
$res=mysqli_query("SELECT * FROM superadmin where superadmin_empid=$id") or die(mysqli_error());
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
<a class='spanhead'>Registrar</a>
<a href='../superadminhome.php' class='back'>&#8629 Back to Home</a>
</span>
<br>
<br>
<center>
<?php
$staff=mysqli_query("SELECT * FROM registrar where status='ACTIVATE' or status='DEACTIVATE' order by ctr") or die(mysqli_error());


	$stf=mysqli_num_rows($staff);

	echo"<table class='list2'>
		<tr>
			<td colspan='8'>No. of Staff : $stf
				<a href='addstaff.php' class='new-or-add'>+ Add Registrar</a></td>
		</tr>
		<tr>
			<td>ctr</td>
			<td>EmpNo</td>
			<td>Lastname</td>
			<td>GivenName</td>
			<td>Designation</td>
			<td>Action</td>
		</tr>";
		$c=1;
		while($s=mysqli_fetch_array($staff))
		{
		echo'
				<tr>
					<td>'.$c++.'</td>
					<td>'.$s["empid"].'</td>
					<td>'.$s["lname"].'</td>
					<td>'.$s["gname"].'</td>
					<td>'.$s["designation"].'</td>
					<td width=200px>';
					?><form method="POST" action="editstaff.php?id=<?php echo''.$s["ctr"].''; ?>">
					<input type="submit" value="Edit" name="editstaff" style='float:left'></form>
					
					<?php
					if ($s["status"]=="DEACTIVATE")
					{
					?>
					<form method=POST action="Activatestaff.php?id=<?php echo''.$s["ctr"].''; ?>">
					<span onclick="return confirm('Are you sure you want to Activate this record?')"><input type="hidden" name="id" value="<?php echo''.$s["ctr"].''; ?>" /><input type="submit" value="Activate" name="activate" style='float:left'></form></span>
					<?php } 
					else if($s["status"]=="ACTIVATE")
					{
					?>
					<form method=POST action="Deactivatestaff.php?id=<?php echo''.$s["ctr"].''; ?>">
					<span onclick="return confirm('Are you sure you want to Deactivate this record?')"><input type="hidden" name="id" value="<?php echo''.$s["ctr"].''; ?>" /><input type="submit" value="Deactivate" name="deactivate" style='float:left'></form></span>
					<?php } ?>
					
					
					<form method=POST action="Deletestaff.php?id=<?php echo''.$s["ctr"].''; ?>">
					<span onclick="return confirm('Are you sure you want to Delete this record?')"><input type="hidden" name="id" value="<?php echo''.$s["ctr"].''; ?>" /><input type="submit" value="Delete" name="delete" style='float:left'></form></span>
					
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