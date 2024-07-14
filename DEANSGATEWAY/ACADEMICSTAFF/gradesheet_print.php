<?php
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
table, td, th {
    border: 1px solid #aaa;
}
table {
    border-collapse:collapse; 
    border:1px solid maroon; 
    font-size:12px; 
    width:90%; 
    color:black;
}
table tr[head] {
    font-weight:bold;
    height:30px;
    background:maroon;
    color:white;
    text-align:center;
}
table tr:not(:last-child) {
    border-bottom:1px solid black;
}
table tr:not(:first-child) td:not(:nth-child(2)) {
    text-align:center;
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
<body onload="startTime()" style='background:white'>
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
echo "<center>
<img src='../../UEPlogo.png'/> 
<br><b>GRADESHEET</b><br>";
if($rows['sem'] == 'summer') {
    echo $rows['sem'];
}
else {
    echo $rows['sem'] . " sem";
}
echo ", SY $rows[syear] <br><br>";
echo "<b>$course_desc</b>";
print "<br>
<table style='text-align:center'>
<tr>
    <td><b>Subject Code</b></td>
    <td><b>No. of Units</b></td> 
    <td><b>Time/Days</b></td>
</tr>
<tr>
    <td>$course_code</td>
    <td>$course_units</td>
    <td>";
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
                                                                echo''.$insfetch['lname'].', '.$insfetch['gname'].';<br>';
                                                            }
print "</td>
    </tr>
    </table>
    <br>
        <table>
        <tr head>
            <td width='25px'>#</td>
            <td>Name of Students</td>
            <td>Prelim</td>
            <td>Midterm</td>
            <td>Pre-Final</td>
            <td>Tentative Final</td>
            <td>FINAL GRADE</td>
            <td>Numerical Equivalent</td>
            <td>Remarks</td>
        </tr>";
        
$count = 1;
  $sel_students = mysqli_query("SELECT * FROM studentssubjtbl LEFT JOIN studentstbl ON studentssubjtbl.studentid = studentstbl.idno WHERE term = $_SESSION[sem] AND courseid = $course_ID ORDER BY lname") or die(mysqli_error());
   if(mysqli_num_rows($sel_students) > 0) {

    $Passed = 0;
    $Failed = 0;
    $OD = 0;
    $UD = 0;
    $INC = 0;
    $NFE = 0;

    while($stud = mysqli_fetch_array($sel_students)) {
    $num = $count++;
    $sid = $stud['idno'];
    $sel_prelimgrade = mysqli_query("SELECT * FROM prelimgrade WHERE term = $_SESSION[sem] AND courseid= $course_ID AND studentid = $sid");
        $prelim = mysqli_fetch_array($sel_prelimgrade);
            $prelim_grade = $prelim['grade_prelim'];
            $COMPLY = $prelim['complied'];
    $sel_midtermgrade = mysqli_query("SELECT * FROM midtermgrade WHERE term = $_SESSION[sem] AND courseid= $course_ID AND studentid = $sid");
        $midterm_grade = mysqli_fetch_array($sel_midtermgrade)['grade_midterm'];
    $sel_prefinalgrade = mysqli_query("SELECT * FROM prefinalgrade WHERE term = $_SESSION[sem] AND courseid= $course_ID AND studentid = $sid");
        $prefinal_grade = mysqli_fetch_array($sel_prefinalgrade)['grade_prefinal'];
    $sel_finalgrade = mysqli_query("SELECT * FROM finalgrade WHERE term = $_SESSION[sem] AND courseid= $course_ID AND studentid = $sid");
        $final_grade = mysqli_fetch_array($sel_finalgrade)['grade_final'];
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

    if($FINAL_GRADE > 75) { $remarks = 'Passed';}
    else { $remarks = 'Failed';}

    if($COMPLY == 'Yes') {
       $sel_gradesheet = mysqli_query("SELECT * FROM gradesheet WHERE term = $sem AND courseid= $course_ID AND studentid = $sid ");
        $num_equiv = mysqli_fetch_array($sel_gradesheet)['grade'];
        $numerical_equivalent =  $num_equiv;

        if($numerical_equivalent =='5.00' OR $numerical_equivalent == 'NFE' OR $numerical_equivalent == 'OD' OR $numerical_equivalent == 'UD' OR $numerical_equivalent == 'INC' ) {
            $remarks = 'Failed';
            if($numerical_equivalent == 'OD') { $OD++; }
            elseif($numerical_equivalent == 'UD') { $UD++; }
            elseif($numerical_equivalent == 'NFE') { $NFE++; }
            elseif($numerical_equivalent == 'INC') { $INC++; }
        }
        else {
            $remarks = 'Passed';
        }

    }

    if($remarks == 'Failed') { $Failed++; } 
    else { $Passed++;}

print "<tr>
            <td>$num</td>
            <td>$stud[lname], $stud[gname]</td>
            <td>$prelim_grade</td>
            <td>$midterm_grade</td>
            <td>$prefinal_grade</td>
            <td>$final_grade</td>
            <td><b>$FINAL_GRADE</b></td>
            <td><b>$numerical_equivalent</b></td>
            <td>$remarks</td>
        </tr>";
    }
}
else {

}
echo "</table><br>
     <table style='border:1px solid black;'>
        <tr>
            <td>
                SUMMARY <br>
                No. of Students Enrolled: $num <br>
                No. of Students Passed: $Passed<br>
                No. of Students Failed: $Failed<br>
            </td>
            <td>
                <br>
                No. of Students NFE: $NFE<br>
                No. of Students INC: $INC<br>
                No. of Students Dropped(OD): $OD<br>
                No. of Students Dropped(UD): $UD<br>
            </td>
        </tr>
    </table>
    <br>
    <center>";
?>
