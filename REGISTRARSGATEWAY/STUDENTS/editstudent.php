<?php
	ob_start();
	session_start();
	include('conn.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Registrar's Gateway</title>
<script src='jquery.min.js'></script>
<style>
<?php 
	require "../frame-css.txt"; 
	require "../fillup-table-css.txt";
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

	$studentinfo = mysqli_query("SELECT * FROM studentstbl WHERE idno = $_GET[sid] ") or die(mysqli_error());
	if(mysqli_num_rows($studentinfo) > 0) {
		$data = mysqli_fetch_array($studentinfo);
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
		$PROGRAM 		= $data['program'];
		$ADMISSIONTYPE 	= $data['admissiontype'];
		$HIGHSCHOOL 	= $data['highschool'];
		$ADDRESS 		= $data['address'];
		$COUNTRY 		= $data['country'];
		$AWARDS  		= $data['awards'];
		$INCLUSIVEYRS 	= $data['inclusiveyears'];
	}
	else {
		Header('Location:index.php');
	}
?>
			<script>
			$(document).ready(function() {
				$('#idno').val(<?php echo $IDNO;?>);
				$('#idno').focus();
				$('#lname').val('<?php echo $LNAME; ?>');
				$('#gname').val('<?php echo $GNAME; ?>');
				$("#sex[value='<?php echo $SEX;?>']").prop('checked',true);
				$("#civilstat option[value='<?php echo $CIVILSTAT;?>']").prop('selected',true);
				$('#citizenship').val('<?php echo $CITIZENSHIP; ?>');
				$('#occupation').val('<?php echo $OCCUPATION; ?>');
				$('#bdate').val('<?php echo $BDATE; ?>');
				$('#bplace').val('<?php echo $BPLACE ?>');
				$('#mobile').val('<?php echo $MOBILE; ?>');	
				$('#email').val('<?php echo $EMAIL; ?>');
				$("#program option[value='<?php echo $PROGRAM;?>']").prop('selected',true);
				$("#admissiontype[value='<?php echo $ADMISSIONTYPE;?>']").prop('checked',true);
				$('#highschool').val('<?php echo $HIGHSCHOOL; ?>');
				$('#address').val('<?php echo $ADDRESS; ?>');
				$('#country').val('<?php echo $COUNTRY; ?>');
				$('#awards').val('<?php echo $AWARDS; ?>');
				$('#inclusiveyears').val('<?php echo $INCLUSIVEYRS; ?>');
			});
			</script>
<div warp>
	<?php include "info.php"; ?>
	<div d2>
		<span class='divhead'>
		<a class='spanhead'>Update Student's Info</a>
		<a href='index.php' class='back' title='Cancel updating' >&#8629 Back to Students</a>
		</span>
		<form method='POST'>
		<table class='fillup2'>
			<tr class='head'>
				<td colspan='2'>Admission Information</td>
			</tr>
			<tr>
				<td>Admission Type: 
					<input type='radio' id= 'admissiontype' name='admissiontype' value='New' checked>New |
					<input type='radio' id='admissiontype' name='admissiontype' value='Transferee'>Transferee
				
				</td>
				<td>Program (Course) <br>
					<select name='program' id='program'>
					<?php
						$programs = mysqli_query('SELECT * FROM programs') or die(mysqli_error());
						while($data = mysqli_fetch_array($programs)) {
							echo "<option value='$data[id]' title='$data[programdesc]'>$data[abbreviation]</option>";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>ID No. <br><input type='text' name='idno' id='idno' Title='ID number' pattern='[0-9]{1,}'required/></td>
				<td></td>
			</tr>
			<tr class='blank'><td colspan='2'></td></tr>
			<tr class='head'>
				<td colspan='2'>Personal Information</td>
			</tr>
			<tr>
				<td>Given Name <br> <input type='text' id='gname' name='gname' required/></td>
				<td>Last Name <br> <input type='text' id='lname' name='lname' required/></td>
			</tr>
			<tr>
				<td>Civil Status <br> 
					<select name='civilstat' id='civilstat'>
						<option value='Single'>Single</option>
						<option value='Married'>Married</option>
					</select>
				</td>
				<td>Sex <br>
					<input type='radio' name='sex' id='sex' value='Male' checked>Male
					<input type='radio' name='sex' id='sex' value='Female'>Female
				</td>
			</tr>
			<tr>
				<td>Birthdate <br> <input type='text' id='bdate' name='bdate' placeholder='mm/dd/yyyy'  pattern="\d{1,2}/\d{1,2}/\d{4}" required></td>
				<td>Birthplace <br> <input type='text' id='bplace' name='bplace' class='long' required></td>
			</tr>
			<tr>
				<td>Citizenship <br> <input type='text'  id='citizenship' name='citizenship' required></td>
				<td>Occupation <br> <input type='text'  id='occupation' name='occupation' ></td>
			</tr>
			<tr>
				<td>Mobile <br> <input type='text' id='mobile' name='mobile' pattern='(\+639)[0-9]{9}' required></td>
				<td>Email <br> <input type='email' id='email' name='email' required></td>
			</tr>
			</tr>
			<tr class='blank'><td colspan='2'></td></tr>
			<tr class='head'>
				<td colspan='2'>High School Information</td>
			</tr>
			<tr>
				<td>Highschool <br> <input type='text' id='highschool' name='highschool' required></td>
				<td>Address <br> <input type='text' id='address' name='address' required></td>
			</tr>
			<tr>
				<td>Country <br> <input type='text' id='country' name='country' required></td>
				<td>Awards <br> <input type='text' id='awards' name='awards'></td>
			</tr>
			<tr>
				<td> </td>
				 <td>Inclusive years <br> <input type='text' id='inclusiveyears' name='inclusiveyears'></td>
			</tr>
			<tr>
				<td colspan='2'><center><input type='submit' name='savestudent' value='SAVE &#10147;' class='button'></center></td>
			</tr>
		</table>
	</form>
	</div>
</div>
</body>
</html>

<?php
if(isset($_POST['savestudent'])) {
	$IDNO 			= $_POST['idno'];
					//ucwords() - Turn every first letter of each word into UPPERCASE
	$LNAME 			= mysqli_real_escape_string(ucwords(strtolower($_POST['lname'])));
	$GNAME 			= mysqli_real_escape_string(ucwords(strtolower($_POST['gname'])));
	$SEX 			= $_POST['sex'];
	$CIVILSTAT 		= $_POST['civilstat'];
	$CITIZENSHIP 	= mysqli_real_escape_string(ucwords(strtolower($_POST['citizenship'])));
	$OCCUPATION 	= mysqli_real_escape_string(ucwords(strtolower($_POST['occupation'])));
	$BDATE 			= $_POST['bdate'];
	$BPLACE 		= mysqli_real_escape_string(ucwords(strtolower($_POST['bplace'])));
	$MOBILE 		= mysqli_real_escape_string($_POST['mobile']);
	$EMAIL 			= mysqli_real_escape_string($_POST['email']);
	$PROGRAM 		= $_POST['program'];
	$ADMISSIONTYPE 	= $_POST['admissiontype'];
	$YROFADMISSION 	= date('Y');
	$ADMISSIONTERM 	= $rows['syear'] . ' ' . $rows['sem'];
	$HIGHSCHOOL		= mysqli_real_escape_string(ucwords(strtolower($_POST['highschool'])));
	$ADDRESS 		= mysqli_real_escape_string(ucwords(strtolower($_POST['address'])));
	$COUNTRY 		= mysqli_real_escape_string(ucwords(strtolower($_POST['country'])));
	$AWARDS 		= mysqli_real_escape_string(ucwords(strtolower($_POST['awards'])));
	$INCLUSIVEYRS 	= mysqli_real_escape_string(ucwords(strtolower($_POST['inclusiveyears'])));
	$VERIFIEDBY		= $row['gname'] . ' ' . $row['lname'];
	$RECORDCRTDON	= date('Y-m-d H:i:s A');

	if($IDNO == $_GET['sid']) {
			update();
	}
	else {
		$checkIDNO = mysqli_query("SELECT * FROM studentstbl WHERE idno = $IDNO OR mobile = '$MOBILE' ") or die(mysqli_error());
		if(mysqli_num_rows($checkIDNO) > 0){
?>
			<script>
			$(document).ready(function() {
				alert('Warning! IDno or Mobile is already on the database.');
				$('#idno').focus();
				$('#idno').val('<?php echo $IDNO; ?>');
				$('#lname').val('<?php echo $LNAME; ?>');
				$('#gname').val('<?php echo $GNAME; ?>');
				$("#sex[value='<?php echo $SEX;?>']").prop('checked',true);
				$("#civilstat option[value='<?php echo $CIVILSTAT;?>']").prop('selected',true);
				$('#citizenship').val('<?php echo $CITIZENSHIP; ?>');
				$('#occupation').val('<?php echo $OCCUPATION; ?>');
				$('#bdate').val('<?php echo $BDATE; ?>');
				$('#bplace').val('<?php echo $BPLACE ?>');
				$('#mobile').val('<?php echo $MOBILE; ?>');	
				$('#email').val('<?php echo $EMAIL; ?>');
				$("#program option[value='<?php echo $PROGRAM;?>']").prop('selected',true);
				$("#admissiontype[value='<?php echo $ADMISSIONTYPE;?>']").prop('checked',true);
				$('#highschool').val('<?php echo $HIGHSCHOOL; ?>');
				$('#address').val('<?php echo $ADDRESS; ?>');
				$('#country').val('<?php echo $COUNTRY; ?>');
				$('#awards').val('<?php echo $AWARDS; ?>');
				$('#inclusiveyears').val('<?php echo $INCLUSIVEYRS; ?>');
			});
			</script>
<?php
		}
		else {
			update();
		}
	}
}

function update() {
	$id=$_SESSION['id2'];
	$sem=$_SESSION['sem3'];
	$res=mysqli_query("SELECT * FROM registrar where ctr=$id") or die(mysqli_error());
	$row=mysqli_fetch_array($res);
	$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
	$rows=mysqli_fetch_array($ress);
	
	$IDNO 			= $_POST['idno'];
					//ucwords() - Turn every first letter of each word into UPPERCASE
	$LNAME 			= mysqli_real_escape_string(ucwords(strtolower($_POST['lname'])));
	$GNAME 			= mysqli_real_escape_string(ucwords(strtolower($_POST['gname'])));
	$SEX 			= $_POST['sex'];
	$CIVILSTAT 		= $_POST['civilstat'];
	$CITIZENSHIP 	= mysqli_real_escape_string(ucwords(strtolower($_POST['citizenship'])));
	$OCCUPATION 	= mysqli_real_escape_string(ucwords(strtolower($_POST['occupation'])));
	$BDATE 			= $_POST['bdate'];
	$BPLACE 		= mysqli_real_escape_string(ucwords(strtolower($_POST['bplace'])));
	$MOBILE 		= mysqli_real_escape_string($_POST['mobile']);
	$EMAIL 			= mysqli_real_escape_string($_POST['email']);
	$PROGRAM 		= $_POST['program'];
	$ADMISSIONTYPE 	= $_POST['admissiontype'];
	$YROFADMISSION 	= date('Y');
	$ADMISSIONTERM 	= $rows['syear'] . ' ' . $rows['sem'];
	$HIGHSCHOOL		= mysqli_real_escape_string(ucwords(strtolower($_POST['highschool'])));
	$ADDRESS 		= mysqli_real_escape_string(ucwords(strtolower($_POST['address'])));
	$COUNTRY 		= mysqli_real_escape_string(ucwords(strtolower($_POST['country'])));
	$AWARDS 		= mysqli_real_escape_string(ucwords(strtolower($_POST['awards'])));
	$INCLUSIVEYRS 	= mysqli_real_escape_string(ucwords(strtolower($_POST['inclusiveyears'])));
	$VERIFIEDBY		= $row['gname'] . ' ' . $row['lname'];
	$RECORDCRTDON	= date('Y-m-d H:i:s A');

	$SID = $_GET['sid'];
	$checkIDNO = mysqli_query("SELECT * FROM studentstbl WHERE mobile = '$MOBILE' AND idno != $IDNO") or die(mysqli_error());
	if(mysqli_num_rows($checkIDNO) > 0){
	?>
			<script>
			$(document).ready(function() {
				alert('Warning! IDno or Mobile is already on the database.');
				$('#idno').focus();
				$('#idno').val('<?php echo $IDNO; ?>');
				$('#lname').val('<?php echo $LNAME; ?>');
				$('#gname').val('<?php echo $GNAME; ?>');
				$("#sex[value='<?php echo $SEX;?>']").prop('checked',true);
				$("#civilstat option[value='<?php echo $CIVILSTAT;?>']").prop('selected',true);
				$('#citizenship').val('<?php echo $CITIZENSHIP; ?>');
				$('#occupation').val('<?php echo $OCCUPATION; ?>');
				$('#bdate').val('<?php echo $BDATE; ?>');
				$('#bplace').val('<?php echo $BPLACE ?>');
				$('#mobile').val('<?php echo $MOBILE; ?>');	
				$('#email').val('<?php echo $EMAIL; ?>');
				$("#program option[value='<?php echo $PROGRAM;?>']").prop('selected',true);
				$("#admissiontype[value='<?php echo $ADMISSIONTYPE;?>']").prop('checked',true);
				$('#highschool').val('<?php echo $HIGHSCHOOL; ?>');
				$('#address').val('<?php echo $ADDRESS; ?>');
				$('#country').val('<?php echo $COUNTRY; ?>');
				$('#awards').val('<?php echo $AWARDS; ?>');
				$('#inclusiveyears').val('<?php echo $INCLUSIVEYRS; ?>');
			});
			</script>
<?php	
	}
	else {
		$insertQUERY = mysqli_query(" UPDATE studentstbl SET
			idno = $IDNO,
			lname ='$LNAME',
			gname ='$GNAME',
			sex = '$SEX',
			civilstat = '$CIVILSTAT',
			citizenship = '$CITIZENSHIP',
			occupation = '$OCCUPATION',
			bdate = '$BDATE',
			bplace = '$BPLACE',
			mobile = '$MOBILE',
			email = '$EMAIL',
			program = $PROGRAM,
			admissiontype = '$ADMISSIONTYPE',
			yearofadmission = '$YROFADMISSION',
			admissionterm = '$ADMISSIONTERM',
			highschool = '$HIGHSCHOOL',
			address = '$ADDRESS',
			country = '$COUNTRY',
			awards = '$AWARDS',
			inclusiveyears = '$INCLUSIVEYRS',
			verifiedby = '$VERIFIEDBY',
			recordcreatedon = '$RECORDCRTDON'
			WHERE idno = $SID
			 ") or die(mysqli_error());
		
		if(mysqli_affected_rows()==1) {
			echo "<script>alert('Updated')</script>";
			header("Refresh: 1; URL=editstudent.php?sid=$IDNO");
		}
	}
}
?>
