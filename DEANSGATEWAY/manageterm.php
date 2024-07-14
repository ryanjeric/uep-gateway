<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php require "frame-css.txt";?>

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
include('conn.php');
session_start();
if (!isset($_SESSION['id'])){
header('location:index.php');
}
if(isset($_POST['choose'])){
$term=mysqli_real_escape_string($_POST['term']);
$_SESSION['sem']=$term;
header('location:deanshome.php');
}
$inactive = 600; // Set timeout period in seconds

if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        header("Location: logout.php");
    }
}
$_SESSION['timeout'] = time();
?>
<div warp>
<?php require "header1.php";?>
<div d2>
<center>
<span class='divhead'>
<a class='spanhead'>Manage Term</a>
<a href='chooseterm.php' class='back'>&crarr; Choose Term</a>
</span>
<br><br>
<table width=40%;>
<tr>
	<td style='border-bottom:5px solid maroon; background:lavender'>Year Term</td>
	<td style='border-bottom:5px solid maroon; background:lavender'>Action</td></tr>
<?php
if(isset($_POST['deleteterm']))
{
$termid=$_POST['id'];
$query="DELETE from semtbl where id='$termid' LIMIT 1";
$r = mysqli_query($query);
if(mysqli_affected_rows()==1)
		{
		echo'<script type="text/javascript">alert("The record has been successfully Deleted.");</script>';
		echo'<script language="JavaScript"> window.location.href ="manageterm.php" </script>';
		}
		else
		{
		echo'<script language="JavaScript"> window.location.href ="manageterm.php" </script>';
		}
}

?>
<?php
$res=mysqli_query("SELECT * FROM semtbl order by id desc") or die(mysqli_error());
while($rows=mysqli_fetch_array($res))
{
	echo'<tr><td>'.$rows["syear"].' &nbsp '.$rows["sem"].'</td><td>
	<form method=POST>
	<input type=hidden value="'.$rows["id"].'" name=id>';
	?>
	<span onclick="return confirm('Are you sure you want to delete this Term?')"><input type=submit name=deleteterm value=DELETE></form>
	</td></tr></span>
	
<?php
}



?>
<tr><td colspan=2><br><a href=addterm.php class='button'>Add</a><br>
	<span label>***click this button to add NEW YEAR TERM</span>
	</td></tr>
</table>
</form>
<br>
</div>
</div>
</body>
</html>