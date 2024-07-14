<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php require "frame-css.txt";?>


table[newTerm] {
color:maroon;
margin:2%;
padding:1%;
}

td:nth-child(odd) {
text-align:right;
padding:10px;
}

input[year] {
height:30px;
padding-left:10px;
margin-left:10px;
font-size:18px;
width:185px;
overflow:hidden;
}

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

<span class='divhead'>
<a class='spanhead'>+Add Term</a>
<a href='manageterm.php' class='back' title='go back to previous page' back>&#8629; Back</a>
</span>


<center>
<?php
if(isset($_POST['addterm'])){
$syer=mysqli_real_escape_string($_POST['syear']);
$sem=mysqli_real_escape_string($_POST['sem']);

$result=mysqli_query("INSERT INTO semtbl(syear,sem) values ('$syer','$sem')") or die(mysqli_error());
echo'<script type="text/javascript">alert("YEAR TERM SUCCESSFULY ADDED");</script>';
}
?>


<form method=POST>
<table newTerm>
<tr>
	<td>Year</td>
	<td>
	<input type=text name=syear pattern='[0-9-]{9}' title='Enter a valid year' placeholder='e.g 2015-2016' required year>
	</td>
</tr>
<tr>
	<td>Semester/Summer</td>
	<td>
	<select name=sem>
	<option value=1st>1st</option>
	<option value=2nd>2nd</option>
	<option value=summer>summer</option>
	</select>
	</td>
</tr>
<tr>
<td colspan=2><center>
<input type=SUBMIT name=addterm value="+ Add" class='button' />
</td>
</tr>
</table>
</form>

</div>



</div>
</body>

</html>