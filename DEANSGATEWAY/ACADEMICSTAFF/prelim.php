<?php
error_reporting(0);
ob_start();
include('conn.php');
session_start();
$grading = 'PRELIM';
?>
<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
<style>
<?php 
require "../frame-css.txt"; 
require "../list-table-css.txt";
require "../table-css.txt";
?>
input[type='submit'],[sub]{
    height:30px;
    width:180px;
    cursor:pointer;
    font-size:90%;
}
</style>
<script src="../jquery.js"></script>
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

    $(document).ready(function()
    {
        $('input[type="number"]').prop('disabled', true);
        $('input[type="submit"]').prop('disabled', true);

    });

</script>
</head>
<body onload="startTime()">
<?php
if (!isset($_SESSION['id'])){
header('location:index.php');
}
if(!isset($_SESSION['sem']))
{
header('location:chooseterm.php');
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
    <a class='spanhead'>GRADES</a>
    <a href='grades.php' class='back'>&#8629 GO BACK</a>
    </span>
<br><br>
<?php
if(!isset($_SESSION['grades_courseID'])) {
    header('Location:mysched.php');
}
$course_ID = $_SESSION['grades_courseID'];
$sql = mysqli_query("SELECT * FROM coursetbl WHERE id = $course_ID ") or die(mysqli_error());
while($course = mysqli_fetch_array($sql)) {
    $course_desc = $course['coursedesc'];
    $course_code = $course['coursecode'];
    $course_units = $course['nolec'] + $course['nolab'];
}
$SQL = mysqli_query("SELECT * FROM grading_overscore WHERE term = $_SESSION[sem] AND courseid = $course_ID and grading = '$grading' ") or die(mysqli_error());
while($data = mysqli_fetch_array($SQL)) {
    $q1 = $data['q1'];
    $q2 = $data['q2'];
    $q_total = $data['q_total'];
    $r = $data['r'];
    $pw = $data['pw'];
    $exam_lec = $data['exam_lec'];
    $lw1 = $data['lw1'];
    $lw2 = $data['lw2'];
    $lw3 = $data['lw3'];
    $lw_total = $data['lw_total'];
    $cs = $data['cs'];
    $exam_lab = $data['exam_lab'];
}


print  "<table class='simple-style1'>
        <tr><td>Subject Code:</td><td> $course_code</td></tr>
        <tr><td>Subject Description:</td><td>$course_desc</td></tr>
        <tr><td>Units:</td><td>$course_units</td></tr>
        <tr><td>Schedule:</td><td>";
		$sched=mysqli_query("SELECT * FROM schedule where term=$sem and courseid=$course_ID") or die(mysqli_error());
						while($schedfetch=mysqli_fetch_array($sched))
															{
																$roomid=$schedfetch["room"];
																$insid=$schedfetch["instructor"];
																echo'<b>'.$schedfetch["classtype"].'</b>|';

																if($schedfetch['m']==1)
																{
																	echo'M';
																}
																if($schedfetch['t']==1)
																{
																	echo'T';
																}
																if($schedfetch['w']==1)
																{
																	echo'W';
																}
																if($schedfetch['th']==1)
																{
																	echo'TH';
																}
																if($schedfetch['f']==1)
																{
																	echo'F';
																}
																if($schedfetch['s']==1)
																{
																	echo'S';
																}

                                                                if($schedfetch["endmin"] == 0) { $endmin = "00";}
                                                                else {$endmin = $schedfetch["endmin"];}

                                                                if($schedfetch["startmin"] == 0) { $startmin = "00";}
                                                                else {$startmin = $schedfetch["startmin"];}

																echo'|'.$schedfetch["starthr"].' : '.$startmin.' '.$schedfetch["starttypeday"].'
																to '.$schedfetch["endhr"].' : '.$endmin.' '.$schedfetch["endtypeday"].' |';

																$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$roomid") or die(mysqli_error());
																$roomfetch=mysqli_fetch_array($roomquery);
																echo "".$roomfetch['roomname']."/".$roomfetch['type']."| ";

																$instructor=mysqli_query("SELECT * FROM staff where ctr=$insid") or die(mysqli_error());
																$insfetch=mysqli_fetch_array($instructor);
																echo''.$insfetch['lname'].','.$insfetch['gname'].';<br>';
															}
		
		echo"</td></tr>
        </table>";

echo "<center><br>";
$sel_subject = mysqli_query("SELECT * FROM schedule WHERE courseid = $course_ID AND term = $_SESSION[sem] AND classtype = 'LAB' ") or die(mysqli_error());
if(mysqli_num_rows($sel_subject) > 0) {
    //If there is LAB
    $withlab = 'T';
   print "<form method='POST'>
    <table class='grading-withlab' border=1>
    <tr><td rowspan='5'><b>#</b></td>
        <td rowspan='5'><b>Name of Students</b></td>
        <td colspan='10'><b>LECTURE GRADE</b></td>
        <td rowspan='5'><b>Lecture Grade</b></td>
        <td colspan='9'><b>LABORATORY GRADE</td>
        <td rowspan='5'><b>Lab Grade</b></td>
        <td rowspan='5'><b>Prelim Grade</b></td>
    </tr>
    <tr>
        <td colspan='4'>QUIZ</td>
        <td colspan='2'>R</td>
        <td colspan='2'>PW</td>
        <td colspan='2'>Exam</td>
        <td colspan='5'>LABORATORY WORK</td>
        <td colspan='2'>Class Participation</td>
        <td colspan='2'>Exam</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td rowspan='2'>Total</td>
        <td rowspan='2'>QUIZ</td>
        <td></td>
        <td rowspan='2'>R</td>
        <td rowspan='2'>PW</td>
        <td rowspan='2'>Total</td>
        <td rowspan='2'>Score</td>
        <td rowspan='2'>Exam</td>
        <td></td>
        <td></td>
        <td></td>
        <td rowspan='2'>Total</td>
        <td rowspan='2'>LW</td>
        <td rowspan='2'>CS</td>
        <td rowspan='3'>Equiv</td>
        <td rowspan='2'>Score</td>
        <td rowspan='3'>Equiv</td>
    </tr>
    <tr>
        <td>Q1</td>
        <td>Q2</td>
        <td>R</td>
        <td>LW1</td>
        <td>LW2</td>
        <td>LW3</td>
    </tr>
    <tr>
        <td><input type='number' name='q1' value='$q1'></td>
        <td><input type='number' name='q2' value='$q2'></td>
        <td>$q_total</td>
        <td>Equiv</td>
        <td><input type='number' name='r' value='$r'></td>
        <td>Equiv</td>
        <td><input type='number' name='pw' value='$pw'></td>
        <td>Equiv</td>
        <td><input type='number' name='exam_lec' value='$exam_lec'></td>
        <td>Equiv</td>
        <td><input type='number' name='lw1' value='$lw1'></td>
        <td><input type='number' name='lw2' value='$lw2'></td>
        <td><input type='number' name='lw3' value='$lw3'></td>
        <td>$lw_total</td>
        <td>Equiv</td>
        <td><input type='number' name='cs' value='$cs'></td> 
        <td><input type='number' name='exam_lab' value='$exam_lab'></td>       
    </tr>";

    //STUDENTS LOOP BEGINS HERE
    $sel_students = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN studentstbl ON studentssubjtbl.studentid = studentstbl.idno WHERE term = $_SESSION[sem] AND courseid = $course_ID ORDER BY lname") or die(mysqli_error());
    if(mysqli_num_rows($sel_students) > 0) {
        //If there are STUDENTS in this subject
        print "<tr>";
        $count = 1;
        while($stud = mysqli_fetch_array($sel_students)) {
            $num = $count++;
            $sid = $stud['idno'];
        echo "<td>$num<input type='hidden' name='student_id[]' value='$sid'></td>";
       
            $sel_studentgrade = mysqli_query("SELECT * FROM prelimgrade WHERE term = $_SESSION[sem] AND courseid = $course_ID AND studentid = $sid LIMIT 1");
            if(mysqli_num_rows($sel_studentgrade) > 0) {  
                while($grade = mysqli_fetch_array($sel_studentgrade)) {
                    $quiz1 = $grade['q1'];
                    $quiz2 = $grade['q2'];
                    $quiz_total = $grade['q1'] + $grade['q2'];
                    $quiz_equivalent = $grade['q_equivalent'];
                    $r = $grade['r'];
                    $r_equivalent = $grade['r_equivalent'];
                    $pw = $grade['pw'];
                    $pw_equivalent = $grade['pw_equivalent'];
                    $exam_lec = $grade['exam_lec'];
                    $exam_lec_equivalent = $grade['exam_lec_equivalent'];
                    $grade_lec = $grade['grade_lec'];
                    $lw1 = $grade['lw1'];
                    $lw2 = $grade['lw2'];
                    $lw3 = $grade['lw3'];
                    $lw_total = $grade['lw1'] + $grade['lw2'] + $grade['lw3'];
                    $lw_equivalent = $grade['lw_equivalent'];
                    $cs = $grade['cs'];
                    $cs_equivalent = $grade['cs_equivalent'];
                    $exam_lab = $grade['exam_lab'];
                    $exam_lab_equivalent = $grade['exam_lab_equivalent'];
                    $grade_lab = $grade['grade_lab'];
                    $grade_prelim = $grade['grade_prelim'];
                   
        print "
                <td align=left>$stud[lname], $stud[gname]</td>
                <td><input type='number' name='q1$sid' value='$quiz1'></td>
                <td><input type='number' name='q2$sid' value='$quiz2'></td>
                <td>$quiz_total</td>
                <td>$quiz_equivalent</td>
                <td><input type='number' name='r$sid' value='$r'></td>
                <td>$r_equivalent</td>
                <td><input type='number' name='pw$sid' value='$pw'></td>
                <td>$pw_equivalent</td>
                <td><input type='number' name='exam_lec$sid' value='$exam_lec'></td>
                <td>$exam_lec_equivalent</td>
                <td><b>$grade_lec</b></td>
                <td><input type='number' name='lw1$sid' value='$lw1'></td>
                <td><input type='number' name='lw2$sid' value='$lw2'></td>
                <td><input type='number' name='lw3$sid' value='$lw3'></td>
                <td>$lw_total</td>
                <td>$lw_equivalent</td>
                <td><input type='number' name='cs$sid' value='$cs'></td>
                <td>$cs_equivalent</td>
                <td><input type='number' name='exam_lab$sid' value='$exam_lab'></td>
                <td>$exam_lab_equivalent</td>
                <td><b>$grade_lab</b></td>
                <td><b>$grade_prelim</b></td>
                </tr>";
                }
            }
            else {
                print "
                <td align=left>$stud[lname], $stud[gname]</td>
                <td><input type='number' name='q1$sid'></td>
                <td><input type='number' name='q2$sid'></td>
                <td></td>
                <td></td>
                <td><input type='number' name='r$sid'></td>
                <td></td>
                <td><input type='number' name='pw$sid'></td>
                <td></td>
                <td><input type='number' name='exam_lec$sid'></td>
                <td></td>
                <td><b></b></td>
                <td><input type='number' name='lw1$sid' ></td>
                <td><input type='number' name='lw2$sid' ></td>
                <td><input type='number' name='lw3$sid' ></td>
                <td></td>
                <td></td>
                <td><input type='number' name='cs$sid'></td>
                <td></td>
                <td><input type='number' name='exam_lab$sid'></td>
                <td></td>
                <td><b></b></td>
                <td><b></b></td>
                </tr>";
            }
        }   
    }
    else { echo "<tr><td colspan='24'>NO STUDENTS</td></tr>";}
echo "</table><br>
        <a href='prelim_print.php' target='_blank' buttonlike>Printable View</a>
    </form>";
}
// IF THERES NO LABORATORY
else {
    $withlab = 'F';
     print "<form method='POST'>
    <table class='grading-withlab' border=1>
    <tr><td rowspan='5'><b>#</b></td>
        <td rowspan='5'><b>Name of Students</b></td>
        <td colspan='10'><b>LECTURE GRADE</b></td>
        <td rowspan='5'><b>Lecture Grade</b></td>
        <td rowspan='5'><b>Prelim Grade</b></td>
    </tr>
    <tr>
        <td colspan='4'>QUIZ</td>
        <td colspan='2'>R</td>
        <td colspan='2'>PW</td>
        <td colspan='2'>Exam</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td rowspan='2'>Total</td>
        <td rowspan='2'>QUIZ</td>
        <td></td>
        <td rowspan='2'>R</td>
        <td rowspan='2'>PW</td>
        <td rowspan='2'>Total</td>
        <td rowspan='2'>Score</td>
        <td rowspan='2'>Exam</td>
    </tr>
    <tr>
        <td>Q1</td>
        <td>Q2</td>
        <td>R</td>
    </tr>
    <tr>
        <td><input type='number' name='q1' value='$q1'></td>
        <td><input type='number' name='q2' value='$q2'></td>
        <td>$q_total</td>
        <td>Equiv</td>
        <td><input type='number' name='r' value='$r'></td>
        <td>Equiv</td>
        <td><input type='number' name='pw' value='$pw'></td>
        <td>Equiv</td>
        <td><input type='number' name='exam_lec' value='$exam_lec'></td>
        <td>Equiv</td>      
    </tr>";

    //STUDENTS LOOP BEGINS HERE
    $sel_students = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN studentstbl ON studentssubjtbl.studentid = studentstbl.idno WHERE term = $_SESSION[sem] AND courseid = $course_ID ORDER BY lname") or die(mysqli_error());
    if(mysqli_num_rows($sel_students) > 0) {
        //If there are STUDENTS in this subject
        print "<tr>";
        $count = 1;
        while($stud = mysqli_fetch_array($sel_students)) {
            $num = $count++;
            $sid = $stud['idno'];
        echo "<td>$num<input type='hidden' name='student_id[]' value='$sid'></td>";
       
            $sel_studentgrade = mysqli_query("SELECT * FROM prelimgrade WHERE term = $_SESSION[sem] AND courseid = $course_ID AND studentid = $sid LIMIT 1");
            if(mysqli_num_rows($sel_studentgrade) > 0) {  
                while($grade = mysqli_fetch_array($sel_studentgrade)) {
                    $quiz1 = $grade['q1'];
                    $quiz2 = $grade['q2'];
                    $quiz_total = $grade['q1'] + $grade['q2'];
                    $quiz_equivalent = $grade['q_equivalent'];
                    $r = $grade['r'];
                    $r_equivalent = $grade['r_equivalent'];
                    $pw = $grade['pw'];
                    $pw_equivalent = $grade['pw_equivalent'];
                    $exam_lec = $grade['exam_lec'];
                    $exam_lec_equivalent = $grade['exam_lec_equivalent'];
                    $grade_lec = $grade['grade_lec'];
                    $lw1 = $grade['lw1'];
                    $lw2 = $grade['lw2'];
                    $lw3 = $grade['lw3'];
                    $lw_total = $grade['lw1'] + $grade['lw2'] + $grade['lw3'];
                    $lw_equivalent = $grade['lw_equivalent'];
                    $cs = $grade['cs'];
                    $cs_equivalent = $grade['cs_equivalent'];
                    $exam_lab = $grade['exam_lab'];
                    $exam_lab_equivalent = $grade['exam_lab_equivalent'];
                    $grade_lab = $grade['grade_lab'];
                    $grade_prelim = $grade['grade_prelim'];
                   
        print "
                <td align='left'>$stud[lname], $stud[gname]</td>
                <td><input type='number' name='q1$sid' value='$quiz1'></td>
                <td><input type='number' name='q2$sid' value='$quiz2'></td>
                <td>$quiz_total</td>
                <td>$quiz_equivalent</td>
                <td><input type='number' name='r$sid' value='$r'></td>
                <td>$r_equivalent</td>
                <td><input type='number' name='pw$sid' value='$pw'></td>
                <td>$pw_equivalent</td>
                <td><input type='number' name='exam_lec$sid' value='$exam_lec'></td>
                <td>$exam_lec_equivalent</td>
                <td><b>$grade_lec</b></td>
                <td><b>$grade_prelim</b></td>
                </tr>";
                }
            }
            else {
                print "
                <td align=left>$stud[lname], $stud[gname]</td>
                <td><input type='number' name='q1$sid'></td>
                <td><input type='number' name='q2$sid'></td>
                <td></td>
                <td></td>
                <td><input type='number' name='r$sid'></td>
                <td></td>
                <td><input type='number' name='pw$sid'></td>
                <td></td>
                <td><input type='number' name='exam_lec$sid'></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>";
            }
        }   
    }
    else { echo "<tr><td colspan='24'>NO STUDENTS</td></tr>";}
echo "</table><br>
        <a href='prelim_print.php' target='_blank' buttonlike>Printable View</a>
    </form></center>";
}
?>
<br><br>
</div>
</div>
</body>
</html>
<?php
if(isset($_POST['save'])) {
    $Q_TOTAL = $_POST['q1'] + $_POST['q2'];
    $LW_TOTAL = $_POST['lw1'] + $_POST['lw2'] + $_POST['lw3'];
    $check = mysqli_query("SELECT * FROM grading_overscore WHERE term = $_SESSION[sem] AND courseid = $course_ID AND grading ='$grading' ") or die(mysqli_error());
    if(mysqli_num_rows($check) < 1) {
        $ins_overscore = mysqli_query("INSERT INTO grading_overscore VALUES (
                    '',
                    '$_SESSION[sem]',
                    '$course_ID',
                    '$grading',
                    '$_POST[q1]',
                    '$_POST[q2]',
                    '$Q_TOTAL',
                    '$_POST[r]',
                    '$_POST[pw]',
                    '$_POST[exam_lec]',
                    '$_POST[lw1]',
                    '$_POST[lw2]',
                    '$_POST[lw3]',
                    '$LW_TOTAL',
                    '$_POST[cs]',
                    '$_POST[exam_lab]',
                    'F'
                    )") or die(mysqli_error());
    }
    else {
        $overscore_ID = mysqli_fetch_array($check)['overscoreid'];
        $up_overscore = mysqli_query("UPDATE grading_overscore SET
                    q1 = '$_POST[q1]',
                    q2 = '$_POST[q2]',
                    q_total = '$Q_TOTAL',
                    r = '$_POST[r]',
                    pw = '$_POST[pw]',
                    exam_lec = '$_POST[exam_lec]',
                    lw1 = '$_POST[lw1]',
                    lw2 = '$_POST[lw2]',
                    lw3 = '$_POST[lw3]',
                    lw_total = '$LW_TOTAL',
                    cs = '$_POST[cs]',
                    exam_lab = '$_POST[exam_lab]'
                    WHERE overscoreid = $overscore_ID ") or die(mysqli_error());
    }
   

   foreach($_POST['student_id'] as $sid) {
        $Q1 = "q1".$sid;
        $Q2 = "q2".$sid;
            $Q_equivalent = (((($_POST[$Q1] + $_POST[$Q2])/($_POST['q1']+$_POST['q2']))*50)+50);
        $R = "r".$sid;
            $R_equivalent = ((($_POST[$R]/$_POST['r'])*50)+50);
        $PW = "pw".$sid;
            $PW_equivalent = ((($_POST[$PW]/$_POST['pw'])*50)+50);
        $EXAM_LEC = "exam_lec".$sid;
            $EXAM_LEC_equivalent = ((($_POST[$EXAM_LEC]/$_POST['exam_lec'])*50)+50);
        $GRADE_LEC = number_format(($Q_equivalent*.3) + ($R_equivalent*.2) + ($PW_equivalent*.1) + ($EXAM_LEC_equivalent*.4),2);
        $LW1 = "lw1".$sid;
        $LW2 = "lw2".$sid;
        $LW3 = "lw3".$sid;
            $LW_equivalent = (((($_POST[$LW1] + $_POST[$LW2] + $_POST[$LW3])/($_POST['lw1'] + $_POST['lw2'] + $_POST['lw3']))*50)+50);
        $CS = "cs".$sid;
            $CS_equivalent = ((($_POST[$CS]/$_POST['cs'])*50)+50);
        $EXAM_LAB = "exam_lab".$sid;
            $EXAM_LAB_equivalent = ((($_POST[$EXAM_LAB]/$_POST['exam_lab'])*50)+50);
        $GRADE_LAB = ($LW_equivalent*.4) + ($CS_equivalent*.1) + ($EXAM_LAB_equivalent*.5);
        $GRADE = ($GRADE_LEC*.5) + ($GRADE_LAB*.5);

        $check = mysqli_query("SELECT * FROM prelimgrade WHERE term = $_SESSION[sem] AND courseid = $course_ID AND studentid = $sid");
        $prelimgrade_ID = mysqli_fetch_array($check)['prelimgradeid'];
        if(mysqli_num_rows($check) > 0) {
            if ($withlab == 'T') {
             $up_grade = mysqli_query("UPDATE prelimgrade SET
                    q1 = '$_POST[$Q1]',
                    q2 ='$_POST[$Q2]',
                    q_equivalent = '$Q_equivalent',
                    r = '$_POST[$R]',
                    r_equivalent = '$R_equivalent',
                    pw = '$_POST[$PW]',
                    pw_equivalent = '$PW_equivalent',
                    exam_lec = '$_POST[$EXAM_LEC]',
                    exam_lec_equivalent = '$EXAM_LEC_equivalent',
                    grade_lec = '$GRADE_LEC',
                    lw1 = '$_POST[$LW1]',
                    lw2 = '$_POST[$LW2]',
                    lw3 = '$_POST[$LW3]',
                    lw_equivalent = '$LW_equivalent',
                    cs = '$_POST[$CS]',
                    cs_equivalent = '$CS_equivalent',
                    exam_lab = '$_POST[$EXAM_LAB]',
                    exam_lab_equivalent = '$EXAM_LAB_equivalent',
                    grade_lab = '$GRADE_LAB',
                    grade_prelim = '$GRADE'
                    WHERE prelimgradeid = $prelimgrade_ID")or die(mysqli_error());
            }
            else {
                $up_grade = mysqli_query("UPDATE prelimgrade SET
                q1 = '$_POST[$Q1]',
                q2 ='$_POST[$Q2]',
                q_equivalent = '$Q_equivalent',
                r = '$_POST[$R]',
                r_equivalent = '$R_equivalent',
                pw = '$_POST[$PW]',
                pw_equivalent = '$PW_equivalent',
                exam_lec = '$_POST[$EXAM_LEC]',
                exam_lec_equivalent = '$EXAM_LEC_equivalent',
                grade_lec = '$GRADE_LEC',
                grade_prelim = '$GRADE_LEC'
                WHERE prelimgradeid = $prelimgrade_ID")or die(mysqli_error());
        
            }

        }
        else {
            if ($withlab == 'T') {
            $ins_grade = mysqli_query("INSERT INTO prelimgrade VALUES (
                    '',
                    '$_SESSION[sem]',
                    '$course_ID',
                    '$sid',
                    '$_POST[$Q1]',
                    '$_POST[$Q2]',
                    '$Q_equivalent',
                    '$_POST[$R]',
                    '$R_equivalent',
                    '$_POST[$PW]',
                    '$PW_equivalent',
                    '$_POST[$EXAM_LEC]',
                    '$EXAM_LEC_equivalent',
                    '$GRADE_LEC',
                    '$_POST[$LW1]',
                    '$_POST[$LW2]',
                    '$_POST[$LW3]',
                    '$LW_equivalent',
                    '$_POST[$CS]',
                    '$CS_equivalent',
                    '$_POST[$EXAM_LAB]',
                    '$EXAM_LAB_equivalent',
                    '$GRADE_LAB',
                    '$GRADE'
                    )")or die(mysqli_error());
            } 
            else {
              $ins_grade = mysqli_query("INSERT INTO prelimgrade VALUES (
                    '',
                    '$_SESSION[sem]',
                    '$course_ID',
                    '$sid',
                    '$_POST[$Q1]',
                    '$_POST[$Q2]',
                    '$Q_equivalent',
                    '$_POST[$R]',
                    '$R_equivalent',
                    '$_POST[$PW]',
                    '$PW_equivalent',
                    '$_POST[$EXAM_LEC]',
                    '$EXAM_LEC_equivalent',
                    '$GRADE_LEC',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '$GRADE_LEC'
                    )")or die(mysqli_error());
            }
        }
   }
   Header('Location:prelim.php');
}

if(isset($_POST['finalposting'])) {
    $Q_TOTAL = $_POST['q1'] + $_POST['q2'];
    $LW_TOTAL = $_POST['lw1'] + $_POST['lw2'] + $_POST['lw3'];
    $check = mysqli_query("SELECT * FROM grading_overscore WHERE term = $_SESSION[sem] AND courseid = $course_ID AND grading ='$grading' ") or die(mysqli_error());
    if(mysqli_num_rows($check) < 1) {
        $ins_overscore = mysqli_query("INSERT INTO grading_overscore VALUES (
                    '',
                    '$_SESSION[sem]',
                    '$course_ID',
                    '$grading',
                    '$_POST[q1]',
                    '$_POST[q2]',
                    '$Q_TOTAL',
                    '$_POST[r]',
                    '$_POST[pw]',
                    '$_POST[exam_lec]',
                    '$_POST[lw1]',
                    '$_POST[lw2]',
                    '$_POST[lw3]',
                    '$LW_TOTAL',
                    '$_POST[cs]',
                    '$_POST[exam_lab]',
                    'T'
                    )") or die(mysqli_error());
    }
    else {
        $overscore_ID = mysqli_fetch_array($check)['overscoreid'];
        $up_overscore = mysqli_query("UPDATE grading_overscore SET
                    q1 = '$_POST[q1]',
                    q2 = '$_POST[q2]',
                    q_total = '$Q_TOTAL',
                    r = '$_POST[r]',
                    pw = '$_POST[pw]',
                    exam_lec = '$_POST[exam_lec]',
                    lw1 = '$_POST[lw1]',
                    lw2 = '$_POST[lw2]',
                    lw3 = '$_POST[lw3]',
                    lw_total = '$LW_TOTAL',
                    cs = '$_POST[cs]',
                    exam_lab = '$_POST[exam_lab]',
                    finalposting = 'T'
                    WHERE overscoreid = $overscore_ID ") or die(mysqli_error());
    }
   

   foreach($_POST['student_id'] as $sid) {
        $Q1 = "q1".$sid;
        $Q2 = "q2".$sid;
            $Q_equivalent = (((($_POST[$Q1] + $_POST[$Q2])/($_POST['q1']+$_POST['q2']))*50)+50);
        $R = "r".$sid;
            $R_equivalent = ((($_POST[$R]/$_POST['r'])*50)+50);
        $PW = "pw".$sid;
            $PW_equivalent = ((($_POST[$PW]/$_POST['pw'])*50)+50);
        $EXAM_LEC = "exam_lec".$sid;
            $EXAM_LEC_equivalent = ((($_POST[$EXAM_LEC]/$_POST['exam_lec'])*50)+50);
        $GRADE_LEC = number_format(($Q_equivalent*.3) + ($R_equivalent*.2) + ($PW_equivalent*.1) + ($EXAM_LEC_equivalent*.4),2);
        $LW1 = "lw1".$sid;
        $LW2 = "lw2".$sid;
        $LW3 = "lw3".$sid;
            $LW_equivalent = (((($_POST[$LW1] + $_POST[$LW2] + $_POST[$LW3])/($_POST['lw1'] + $_POST['lw2'] + $_POST['lw3']))*50)+50);
        $CS = "cs".$sid;
            $CS_equivalent = ((($_POST[$CS]/$_POST['cs'])*50)+50);
        $EXAM_LAB = "exam_lab".$sid;
            $EXAM_LAB_equivalent = ((($_POST[$EXAM_LAB]/$_POST['exam_lab'])*50)+50);
        $GRADE_LAB = ($LW_equivalent*.4) + ($CS_equivalent*.1) + ($EXAM_LAB_equivalent*.5);
        $GRADE = ($GRADE_LEC*.5) + ($GRADE_LAB*.5);

        $check = mysqli_query("SELECT * FROM prelimgrade WHERE term = $_SESSION[sem] AND courseid = $course_ID AND studentid = $sid");
        $prelimgrade_ID = mysqli_fetch_array($check)['prelimgradeid'];
        if(mysqli_num_rows($check) > 0) {
            if ($withlab == 'T') {
             $up_grade = mysqli_query("UPDATE prelimgrade SET
                    q1 = '$_POST[$Q1]',
                    q2 ='$_POST[$Q2]',
                    q_equivalent = '$Q_equivalent',
                    r = '$_POST[$R]',
                    r_equivalent = '$R_equivalent',
                    pw = '$_POST[$PW]',
                    pw_equivalent = '$PW_equivalent',
                    exam_lec = '$_POST[$EXAM_LEC]',
                    exam_lec_equivalent = '$EXAM_LEC_equivalent',
                    grade_lec = '$GRADE_LEC',
                    lw1 = '$_POST[$LW1]',
                    lw2 = '$_POST[$LW2]',
                    lw3 = '$_POST[$LW3]',
                    lw_equivalent = '$LW_equivalent',
                    cs = '$_POST[$CS]',
                    cs_equivalent = '$CS_equivalent',
                    exam_lab = '$_POST[$EXAM_LAB]',
                    exam_lab_equivalent = '$EXAM_LAB_equivalent',
                    grade_lab = '$GRADE_LAB',
                    grade_prelim = '$GRADE'
                    WHERE prelimgradeid = $prelimgrade_ID")or die(mysqli_error());
            }
            else {
                $up_grade = mysqli_query("UPDATE prelimgrade SET
                q1 = '$_POST[$Q1]',
                q2 ='$_POST[$Q2]',
                q_equivalent = '$Q_equivalent',
                r = '$_POST[$R]',
                r_equivalent = '$R_equivalent',
                pw = '$_POST[$PW]',
                pw_equivalent = '$PW_equivalent',
                exam_lec = '$_POST[$EXAM_LEC]',
                exam_lec_equivalent = '$EXAM_LEC_equivalent',
                grade_lec = '$GRADE_LEC',
                grade_prelim = '$GRADE_LEC'
                WHERE prelimgradeid = $prelimgrade_ID")or die(mysqli_error());
        
            }

        }
        else {
            if ($withlab == 'T') {
            $ins_grade = mysqli_query("INSERT INTO prelimgrade VALUES (
                    '',
                    '$_SESSION[sem]',
                    '$course_ID',
                    '$sid',
                    '$_POST[$Q1]',
                    '$_POST[$Q2]',
                    '$Q_equivalent',
                    '$_POST[$R]',
                    '$R_equivalent',
                    '$_POST[$PW]',
                    '$PW_equivalent',
                    '$_POST[$EXAM_LEC]',
                    '$EXAM_LEC_equivalent',
                    '$GRADE_LEC',
                    '$_POST[$LW1]',
                    '$_POST[$LW2]',
                    '$_POST[$LW3]',
                    '$LW_equivalent',
                    '$_POST[$CS]',
                    '$CS_equivalent',
                    '$_POST[$EXAM_LAB]',
                    '$EXAM_LAB_equivalent',
                    '$GRADE_LAB',
                    '$GRADE'
                    )")or die(mysqli_error());
            } 
            else {
              $ins_grade = mysqli_query("INSERT INTO prelimgrade VALUES (
                    '',
                    '$_SESSION[sem]',
                    '$course_ID',
                    '$sid',
                    '$_POST[$Q1]',
                    '$_POST[$Q2]',
                    '$Q_equivalent',
                    '$_POST[$R]',
                    '$R_equivalent',
                    '$_POST[$PW]',
                    '$PW_equivalent',
                    '$_POST[$EXAM_LEC]',
                    '$EXAM_LEC_equivalent',
                    '$GRADE_LEC',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '$GRADE_LEC'
                    )")or die(mysqli_error());
            }
        }
   }
   Header('Location:prelim.php');
}

?>