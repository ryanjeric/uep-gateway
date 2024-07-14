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
<a class='spanhead'>Please Choose Year Term</a>
<a href='manageterm.php' class='back'>&rdsh; Manage Term</a>
</span>
<form method=POST>

<table id='term'>
<tr>
<td>Year term:</td>
<td>
<select name=term>
<?php
$res=mysqli_query("SELECT * FROM semtbl order by id desc") or die(mysqli_error());
while($rows=mysqli_fetch_array($res))
{
	echo'<option value='.$rows["id"].'>'.$rows["syear"].' &nbsp '.$rows["sem"].' </option>';
}


?>
</select>
</td></tr>
<tr>
<td colspan=2>
<center> <br>
<input type=SUBMIT name=choose value='Continue' class='button'></td>
</tr>
</table>
</form>
</div>



</div>
</body>

</html>