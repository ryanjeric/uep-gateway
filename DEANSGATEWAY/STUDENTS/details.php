<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Registrar's Gateway</title>
<script src='jquery.min.js'></script>
<style>
<?php 
	require "../frame-css.txt"; 
	require "../list-table-css.txt";
?>
</style>
<script>
<?php
	require "js-time.txt";
?>
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
	<?php include "info.php"; ?>
<div d2>
<span class='divhead'>
<a class='spanhead'>Students Information</a>
<a href='../STUDENTS' class='back' title='Back to Home' >&#8629 Back to Students</a>
</span>
<center>
	<?php
$student=mysqli_query("SELECT * FROM studentstbl LEFT JOIN programs ON studentstbl.program = programs.id WHERE idno = $_GET[idno] ") or die(mysqli_error());

$data = mysqli_fetch_array($student);
	$IDNO 			= $data['idno'];
	$LNAME 			= $data['lname'];
	$GNAME 			= $data['gname'];
	$SEX 			= $data['sex'];
	$CIVILSTAT 		= $data['civilstat'];
	$CITIZENSHIP 	= $data['citizenship'];
	$OCCUPATION  	= $data['occupation'];
	$BDATE 			= $data['bdate'];
	$BPLACE 		= $data['bplace'];
	$MOBILE 		= $data['mobile'];
	$EMAIL 			= $data['email'];
	$PROGRAM 		= $data['abbreviation'];
	$ADMISSIONTYPE 	= $data['admissiontype'];
	$YROFADMISSION	= $data['yearofadmission'];
	$ADMISSIONTERM	= $data['admissionterm'];
	$HIGHSCHOOL 	= $data['highschool'];
	$ADDRESS 		= $data['address'];
	$COUNTRY 		= $data['country'];
	$AWARDS  		= $data['awards'];
	$INCLUSIVEYRS 	= $data['inclusiveyears'];
	$VERIFIEDBY		= $data['verifiedby'];
	$RECORDCRTDON	= $data['recordcreatedon'];
	$PASSWORD		= $data['password'];
print "
	<table class='details'>
		<tr class='blank'><td colspan='2'>
		</td></tr>
		<tr>
			<td>ID No.</td><td>$IDNO</td>
		</tr>
		<tr class='blank'><td colspan='2'></td></tr>
		<tr class='head'>
			<td></td><td>PERSONAL INFORMATION</td>
		</tr>
		<tr>
			<td>Last Name</td><td>$LNAME</td>
		</tr>
		<tr>
			<td>Given Name</td><td>$GNAME</td>
		</tr>
		<tr>
			<td>Sex</td><td>$SEX</td>
		</tr>
		<tr>
			<td>Civil Status</td><td>$CIVILSTAT</td>
		</tr>
		<tr>
			<td>Citizenship</td><td>$CITIZENSHIP</td>
		</tr>
		<tr>
			<td>Occupation</td><td>$OCCUPATION</td>
		</tr>
		<tr>
			<td>Birthdate</td><td>$BDATE (mm/dd/yyyy)</td>
		</tr>
		<tr>
			<td>Birthplace</td><td>$BPLACE</td>
		</tr>
		<tr>
			<td>Mobile No.</td><td>$MOBILE</td>
		</tr>
		<tr>
			<td>Email</td><td>$EMAIL</td>
		</tr>
		<tr class='blank'><td colspan='2'></td></tr>
		<tr class='head'>
			<td></td><td>ADMISSION INFORMATION</td>
		</tr>
		<tr>
			<td>Program</td><td>$PROGRAM</td>
		</tr>
		<tr>
			<td>Admission Type</td><td>$ADMISSIONTYPE</td>
		</tr>
		<tr>
			<td>Year of Admission</td><td>$YROFADMISSION</td>
		</tr>
		<tr>
			<td>Admission Term</td><td>$ADMISSIONTERM</td>
		</tr>
		<tr class='blank'><td colspan='2'></td></tr>
		<tr class='head'>
			<td></td><td>HIGH SCHOOL INFORMATION</td>
		</tr>
		<tr>
			<td>High School</td><td>$HIGHSCHOOL</td>
		</tr>
		<tr>
			<td>Address</td><td>$ADDRESS</td>
		</tr>
		<tr>
			<td>Country</td><td>$COUNTRY</td>
		</tr>
		<tr>
			<td>Awards</td><td>$AWARDS</td>
		</tr>
		<tr>
			<td>Inclusive Years</td><td>$INCLUSIVEYRS</td>
		</tr>
		<tr class='blank'><td colspan='2'></td></tr>
		<tr class='head'>
			<td></td><td>VERIFICATION INFORMATION</td>
		</tr>
		<tr>
			<td>Verified By</td><td>$VERIFIEDBY</td>
		</tr>
		<tr>
			<td>Record Created On</td><td>$RECORDCRTDON</td>
		</tr>
		<tr class='head'>
			<td></td><td>SECURITY</td>
		</tr>
		<tr>
			<td>Password</td><td>$PASSWORD</td>
		</tr>


	</table>
"

?>
</div>
</div>
</body>
</html>