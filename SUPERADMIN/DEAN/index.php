<?php
ob_start();
include('conn.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>UEP - SUPERADMIN</title>
<style>
<?php
 require "../frame-css.txt"; 
require "../list-table-css.txt";
?>


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
if (!isset($_SESSION['super_id'])){
header('location:../index.php');
}
if(!isset($_SESSION['super_sem']))
{
header('location:../chooseterm.php');
}
?>
<?php
$id=$_SESSION['super_id'];
$sem=$_SESSION['super_sem'];
$res=mysqli_query("SELECT * FROM superadmin where superadmin_empid=$id") or die(mysqli_error());
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
<a class='spanhead'>Dean</a>
<a href='../superadminhome.php' class='back'>&#8629 Back to Home</a>
</span>
<br><br>
<span tenpercent>
    <a href='add_dean.php' class='button-style1' style='float:right;'>Add New</a>
</span>
<table class='style-new1'>
	<tr head>
		<td></td>
		<td>Employee ID</td>
		<td>Name</td>
		<td>Department</td>
        <td>Status</td>
        <td>Action</td>
	</tr>
<?php
    $sql = mysqli_query("SELECT * FROM user WHERE id <> '$id' ") or die(mysqli_error());
    if(mysqli_num_rows($sql) > 0) {
        $rounds = 1;
        while($data = mysqli_fetch_array($sql)) {
            print "<tr>
                        <td>".$rounds++."</td>
                        <td>$data[empid]</td>
                        <td>$data[lname], $data[fname] $data[mname]</td>
                        <td>$data[department]</td>
                        <td>";
                            if($data['status'] == 'ACTIVATED' ) {
                                print "<form action='statusdean.php' method='POST'>
                                    <input type='hidden' name='empid' value='$data[empid]'/>
                                    <input type='submit' name='status' value='DEACTIVATE' style='float:left'/>
                                </form>";
                            }
                            else {
                                 print "<form action='statusdean.php' method='POST'>
                                    <input type='hidden' name='empid' value='$data[empid]'/>
                                    <input type='submit' name='status' value='ACTIVATE' style='float:left'/>
                                </form>";
                            }
                print   "</td>
                        <td>
                        <form action='editdean.php' method='POST'>
                            <input type='hidden' name='empid' value='$data[empid]'/>
                            <input type='submit' name='edit' value='EDIT' style='float:left'/>
                        </form>
                        <form action='deletedean.php' method='POST'>
                            <input type='hidden' name='empid' value='$data[empid]'/>
                            <input type='submit' name='delete' value='DELETE' onclick='return confirm(\"Are you sure you want to perform a delete?\")' />
                        </form>
                        </td>
            </tr>";
        }
    }
    else {
        echo "<tr><td colspan='6'>No other Dean</td></tr>";
    }
?>
</table>
<br>
</div>
</div>
</body>
</html>