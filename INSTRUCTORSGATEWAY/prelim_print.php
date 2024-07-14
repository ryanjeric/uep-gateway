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
<title>Instructor's Gateway</title>
<style>
<?php 
require "frame-css.txt"; 
require "list-table-css.txt";
require "table-css.txt";
?>
input[type='submit'],[sub]{
    height:30px;
    width:180px;
    cursor:pointer;
    font-size:90%;
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
<script src="jquery.js"></script>
</head>
<body style='background:white' onload="startTime()">
<?php
if (!isset($_SESSION['id4'])){
header('location:index.php');
}
if(!isset($_SESSION['sem1']))
{
header('location:chooseterm.php');
}
?>
<?php
$id=$_SESSION['id4'];
$sem=$_SESSION['sem'];
$res=mysqli_query("SELECT * FROM staff where ctr=$id") or die(mysqli_error());
$row=mysqli_fetch_array($res);
$ress=mysqli_query("SELECT * FROM semtbl where id=$sem") or die(mysqli_error());
$rows=mysqli_fetch_array($ress);

if($rows['sem'] == 'summer') {
    $TERM = $rows['sem'] . ", S.Y. $rows[syear]"; 
}
else {
    $TERM = $rows['sem'] . " Semester, S.Y. $rows[syear]";
}

print "<center><br>
    <img src='../UEPlogo.png'/> <br>
    <h1>PRELIM</h1> 
    <h2>Class Record</h2>
    $TERM
</center>
";

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

print  "<table class='simple-style1-print'>
        <tr><td>Subject Code:</td><td> $course_code</td></tr>
        <tr><td>Subject Description:</td><td>$course_desc</td></tr>
        <tr><td>Units:</td><td>$course_units</td></tr>
        <tr><td>Schedule :</td><td>";
						$sched=mysqli_query("SELECT * FROM schedule where term=$sem and courseid=$course_ID and instructor=$id") or die(mysqli_error());
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
																if($schedfetch["startmin"] == 0) { $startmin = "00";}
                                                                else {$startmin = $schedfetch["startmin"];}

                                                                if($schedfetch["endmin"] == 0) { $endmin = "00";}
                                                                else {$endmin = $schedfetch["endmin"];}

                                                                echo'|'.$schedfetch["starthr"].' : '.$startmin.' '.$schedfetch["starttypeday"].'
                                                                to '.$schedfetch["endhr"].' : '.$endmin.' '.$schedfetch["endtypeday"].' |';

																$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$roomid") or die(mysqli_error());
																$roomfetch=mysqli_fetch_array($roomquery);
																echo "".$roomfetch['roomname']."/".$roomfetch['type']."| ";

																$instructor=mysqli_query("SELECT * FROM staff where ctr=$insid") or die(mysqli_error());
																$insfetch=mysqli_fetch_array($instructor);
																echo''.$insfetch['lname'].', '.$insfetch['gname'].';<br>';
															}
					echo"</td></tr>
        </table>";

$check2 = mysqli_query("SELECT * FROM grading_overscore WHERE term = $_SESSION[sem] AND courseid = $course_ID AND grading ='$grading' and finalposting='T'") or die(mysqli_error());
$checkcount=mysqli_num_rows($check2);
if($checkcount==1)
{
    ?>
        <script type="text/javascript">
        $(document).ready(function()
        {
            $('input[type="number"]').prop('disabled', true);
            $('input[type="submit"]').prop('disabled', true);

        })
        </script>
    <?php
}


echo "<center><br>";
$sel_subject = mysqli_query("SELECT * FROM schedule WHERE courseid = $course_ID AND term = $_SESSION[sem] AND classtype = 'LAB' ") or die(mysqli_error());
if(mysqli_num_rows($sel_subject) > 0) {
    //If there is LAB
    $withlab = 'T';
   print "<form method='POST'>
    <table class='grading-withlab-print' border=1>
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
        <td>$q1</td>
        <td>$q2</td>
        <td>$q_total</td>
        <td>Equiv</td>
        <td>$r</td>
        <td>Equiv</td>
        <td>$pw</td>
        <td>Equiv</td>
        <td>$exam_lec</td>
        <td>Equiv</td>
        <td>$lw1</td>
        <td>$lw2</td>
        <td>$lw3</td>
        <td>$lw_total</td>
        <td>Equiv</td>
        <td>$cs</td> 
        <td>$exam_lab</td>       
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
                <td>$quiz1</td>
                <td>$quiz2</td>
                <td>$quiz_total</td>
                <td>$quiz_equivalent</td>
                <td>$r</td>
                <td>$r_equivalent</td>
                <td>$pw</td>
                <td>$pw_equivalent</td>
                <td>$exam_lec</td>
                <td>$exam_lec_equivalent</td>
                <td><b>$grade_lec</b></td>
                <td>$lw1</td>
                <td>$lw2</td>
                <td>$lw3</td>
                <td>$lw_total</td>
                <td>$lw_equivalent</td>
                <td>$cs</td>
                <td>$cs_equivalent</td>
                <td>$exam_lab'></td>
                <td>$exam_lab_equivalent</td>
                <td><b>$grade_lab</b></td>
                <td><b>$grade_prelim</b></td>
                </tr>";
                }
            }
            else {
                print "
                <td align=left>$stud[lname], $stud[gname]</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b></b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b></b></td>
                <td><b></b></td>
                </tr>";
            }
        }   
    }
    else { echo "<tr><td colspan='24'>NO STUDENTS</td></tr>";}
echo "</table><br>
    </form>";
}
// IF THERES NO LABORATORY
else {
    $withlab = 'F';
     print "<form method='POST'>
    <table class='grading-withlab-print' border=1>
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
        <td>$q1</td>
        <td>$q2</td>
        <td>$q_total</td>
        <td>Equiv</td>
        <td>$r</td>
        <td>Equiv</td>
        <td>$pw</td>
        <td>Equiv</td>
        <td>$exam_lec</td>
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
                <td>$quiz1</td>
                <td>$quiz2</td>
                <td>$quiz_total</td>
                <td>$quiz_equivalent</td>
                <td>$r</td>
                <td>$r_equivalent</td>
                <td>$pw</td>
                <td>$pw_equivalent</td>
                <td>$exam_lec</td>
                <td>$exam_lec_equivalent</td>
                <td><b>$grade_lec</b></td>
                <td><b>$grade_prelim</b></td>
                </tr>";
                }
            }
            else {
                print "
                <td align=left>$stud[lname], $stud[gname]</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>";
            }
        }   
    }
    else { echo "<tr><td colspan='24'>NO STUDENTS</td></tr>";}
echo "</table>
    </form><center>";
}
?>
<br><br>
</body>
</html>