<?php
include('conn.php');

$IDNO = $_GET['idno'];

$sql = mysqli_query(" SELECT * FROM studentstbl WHERE idno = $IDNO ");
if(mysqli_num_rows($sql) > 0) {
	$data = mysqli_fetch_array($sql);
	$status = $data['status'];
	if($status == 1) {
		$deactivate = mysqli_query(" UPDATE studentstbl SET status = 0 WHERE idno = $IDNO ");
		if(mysqli_affected_rows()==1) {
			echo "<script>alert('Student Successfully Deactivated.')</script>";
			echo'<script language="JavaScript"> window.location.href ="details.php?idno=' . $IDNO . '" </script>';
		}
	}
	else {
		$activate = mysqli_query(" UPDATE studentstbl SET status = 1 WHERE idno = $IDNO ");
		if(mysqli_affected_rows()==1) {
			echo "<script>alert('Student Successfully Activated.')</script>";
			echo'<script language="JavaScript"> window.location.href ="details.php?idno='. $IDNO . '" </script>';
		}
	}
}
else {
	echo'<script language="JavaScript"> window.location.href ="index.php" </script>';
}
?>