<?php
require "conn.php";


echo "<center><h1>Grade Inquiry</h1></center>";

$sql = mysqli_query("SELECT * FROM ozekimessagein ORDER BY receivedtime DESC LIMIT 10") or die(mysqli_error());
if(mysqli_num_rows($sql) > 0) {
	echo "<table style='border:1px solid maroon; border-collapse:collapse; width:100%; margin:0 auto;'>";
	print 	"<tr style='background:maroon; color:white'>
				<td>Reference</td>
				<td>Sender</td>
				<td>Message</td>
				<td>Time Received</td>
			</tr>";
	//FOR DISPLAYING
	while($data = mysqli_fetch_array($sql)) {
	print 	"<tr>
				<td>$data[reference]</td>
				<td>$data[sender]</td>
				<td>$data[msg]</td>
				<td>$data[receivedtime]</td>
			</tr>";
	}
	echo "<table><br>";
}



	//FOR REPLYING
	$SQL = mysqli_query("SELECT * FROM ozekimessagein WHERE replied = 'No' ") or die(mysqli_error());
	while($data1 = mysqli_fetch_array($SQL)) {
		$reference = $data1['reference'];
		$sender = $data1['sender'];
		$msg = $data1['msg'];
		$msg_year = substr($msg,0,4); 
		$msg_sem = substr($msg,4,1);
		$msg_sy = substr($msg,0,5);
		$msg_mygrade = substr($msg,6,7); 
		$sql_semtbl = mysqli_query("SELECT * FROM semtbl") or die(mysqli_error());
		while($sem = mysqli_fetch_array($sql_semtbl)) {
			$term_year = substr($sem['syear'],0,4);
			$term_sem = substr($sem['sem'],0,1);
			//GETTING THE YEAR TERM if the MESSAGE MATCH THE PROPER KEYWORDS
			if($msg_year == $term_year && $msg_sem == $term_sem && $msg_mygrade == "MYGRADE") {
				$SEM = $sem['id'];
				//GETTING THE IDNO of the SENDER if MOBILE IS MATCH
				$sql_studtbl = mysqli_query("SELECT * FROM studentstbl WHERE mobile = $sender") or die(mysqli_error());
				if(mysqli_num_rows($sql_studtbl) > 0) {
					$STUD_ID = mysqli_fetch_array($sql_studtbl)['idno'];
					// echo "<script type=\"text/javascript\">
					//         window.open('newpage.php', '_blank')
					//     </script>";
					$sql_subj = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN coursetbl ON studentssubjtbl.courseid = coursetbl.id WHERE studentid = $STUD_ID AND term = $SEM ") or die(mysqli_error());
					if(mysqli_num_rows($sql_subj) > 0) {
							$MSG = "";
						while($data2 = mysqli_fetch_array($sql_subj)) {
							$SQL_prelim = mysqli_query("SELECT * FROM prelimgrade WHERE term = $SEM AND studentid = $STUD_ID AND courseid = $data2[courseid] ") or die(mysqli_error());
								$prelim = mysqli_fetch_array($SQL_prelim);
					            $prelim_grade = $prelim['grade_prelim'];
					            $COMPLY = $prelim['complied'];
							$SQL_midterm = mysqli_query("SELECT * FROM midtermgrade WHERE term = $SEM AND studentid = $STUD_ID AND courseid = $data2[courseid] ") or die(mysqli_error());
								$midterm_grade = mysqli_fetch_array($SQL_midterm)['grade_midterm'];
							$SQL_prefinal = mysqli_query("SELECT * FROM prefinalgrade WHERE term = $SEM AND studentid = $STUD_ID AND courseid = $data2[courseid] ") or die(mysqli_error());
								$prefinal_grade = mysqli_fetch_array($SQL_prefinal)['grade_prefinal'];
							$SQL_final = mysqli_query("SELECT * FROM finalgrade WHERE term = $SEM AND studentid = $STUD_ID AND courseid = $data2[courseid] ") or die(mysqli_error());
								$final_grade = mysqli_fetch_array($SQL_final)['grade_final'];
							$FINAL_GRADE = number_format((($prelim_grade+$midterm_grade+$prefinal_grade+$final_grade)/4),2);
						    if($FINAL_GRADE <= 74)      {$numerical_equivalent = '5.00';}
						    elseif ($FINAL_GRADE <= 76) {$numerical_equivalent = '3.00';}
						    elseif ($FINAL_GRADE <= 79) {$numerical_equivalent = '2.75';}
						    elseif ($FINAL_GRADE <= 82) {$numerical_equivalent = '2.50';}
						    elseif ($FINAL_GRADE <= 85) {$numerical_equivalent = '2.25';}
						    elseif ($FINAL_GRADE <= 88) {$numerical_equivalent = '2.00';}
						    elseif ($FINAL_GRADE <= 91) {$numerical_equivalent = '1.75';}
						    elseif ($FINAL_GRADE <= 94) {$numerical_equivalent = '1.50';}
						    elseif ($FINAL_GRADE <= 97) {$numerical_equivalent = '1.25';}
						    elseif ($FINAL_GRADE <= 100) {$numerical_equivalent = '1.00';}

						    if($FINAL_GRADE > 75) { $remarks = 'P';}
						    else { $remarks = 'F';}
						    if($COMPLY == 'Yes') {
						    	$sel_gradesheet = mysqli_query("SELECT * FROM gradesheet WHERE term = $SEM AND courseid= $data2[courseid] AND studentid = $STUD_ID ");
						    	$num_equiv = mysqli_fetch_array($sel_gradesheet)['grade'];
						        $numerical_equivalent =  $num_equiv;
						    }


						    $grades = "$data2[coursecode]=$numerical_equivalent($remarks) || ";
						    $MSG = $MSG . $grades;
						}
						$MSG = "$msg_sy/$STUD_ID >>$MSG";
						echo $MSG;
						echo "<br>";
						$to_cno = $sender; 
						$message=$MSG;
						$sender="UEP";
						$url='http://localhost:9333/ozeki?';
						$url.="action=sendMessage";
						$url.="&login=admin";
						$url.="&password=abc123";
						$url.="&recepient=".urlencode($to_cno);
						$url.="&messageData=".urlencode($message);
						$url.="&sender=".urlencode($sender);
						file($url);
						$update = mysqli_query("UPDATE ozekimessagein SET replied = 'Yes' WHERE reference = $reference") or die(mysqli_error());
					}
					else {
						//IF STUDENT doesnt have any subject
						$MSG = "$msg_sy/$STUD_ID >>You dont have any posted grades";
						echo $MSG;
						$to_cno = $sender; 
						$message=$MSG;
						$sender="UEP";
						$url='http://localhost:9333/ozeki?';
						$url.="action=sendMessage";
						$url.="&login=admin";
						$url.="&password=abc123";
						$url.="&recepient=".urlencode($to_cno);
						$url.="&messageData=".urlencode($message);
						$url.="&sender=".urlencode($sender);
						file($url);
						$update = mysqli_query("UPDATE ozekimessagein SET replied = 'Yes' WHERE reference = $reference") or die(mysqli_error());
					}
				}
			}
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="3" > 
</head>
<body>
<div style='position:fixed; bottom:0;'>Please don't close this page. It's the Grade Inquiry Live Engine.</div>
</body>
</html>
