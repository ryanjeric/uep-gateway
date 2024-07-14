<?php
error_reporting(0)
?>
<!DOCTYPE html>
<html>
<head>
<title>Dean's Gateway</title>
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
include('conn.php');
session_start();
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
<?php
include "info.php";
?>

<div d2>
<span class='divhead'>
<a class='spanhead'>Courses</a>
<a href='index.php' class='back'>&#8629 Cancel Creating Schedule</a>
</span>
<br>
<br>
<center>
<?php
$course=mysqli_query("SELECT * FROM coursetbl where id={$_GET['id']}") or die(mysqli_error());


	$coursenumber=mysqli_num_rows($course);

	echo"<table class='simple-style1'>
		<tr head>
			<td colspan='2'>CREATE SCHEDULE</td> 
		</tr>";
		$courses=mysqli_fetch_array($course);
		$courseid=$courses["id"];
		echo'
				
					<tr><td>TERM :</td><td> <u>'.$rows["syear"].' '.$rows["sem"].'</u></td></tr>
					<tr><td>Course Code</td><td>'.$courses["coursecode"].'</td></tr>
					<tr><td>Course description</td><td>'.$courses["coursedesc"].'</td></tr>
					<tr><td>Section</td><td>'.$courses["section"].'</td></tr>
					<tr><td>No.lec</td><td>'.$courses["nolec"].'</td></tr>
					<tr><td>No.lab</td><td>'.$courses["nolab"].'</td></tr>
					<tr><td>Lab Type</td><td>'.$courses["labtype"].'</td></tr>
					<tr><td>Sluts</td><td>'.$courses["slots"].'</td></tr>
					';

		?>
	</table><br>
	<span section>VERIFY SCHEDULE</span>
	<form method="POST">
	<table class='style-schedule'>
		<tr>
			<td style="max-width:80px;font-size:16px">TYPE</td>
			<td style="max-width:80px;font-size:16px">Schedule Day</td>
			<td style="max-width:80px;font-size:16px">Start Time</td>
			<td style="max-width:80px;font-size:16px">End Time</td>
			<td style="max-width:80px;font-size:16px">ROOM</td>
			<td style="max-width:120px;font-size:16px">INSTRUCTOR</td>
			<td style="max-width:80px;font-size:16px">REMARKS
					<input type=hidden name=term value='<?php echo $sem; ?>'>
					<input type=hidden name=courseid value='<?php echo $courseid; ?>'>


			</td>
		</tr>
		<?php
				if(isset($_POST['step2']))
				{	
					

















					if(isset($_POST['classtype0']))
					{
						$classtype=$_POST['classtype0'];

						$strthr=$_POST['strthr0'];
						$strtmin=$_POST['strtmin0'];
						$strttypeday=$_POST['strttypeday0'];

						$endhr=$_POST['endhr0'];
						$endmin=$_POST['endmin0'];
						$endtypeday=$_POST['endtypeday0'];

						$room=$_POST['Room0'];
						$instructor=$_POST['instructor0'];
						$remarks=mysqli_real_escape_string($_POST['remarks0']);
						echo"<tr>
								<td>$classtype <input type=hidden name=classtype0 value=$classtype></td>
								<td>";
																if(isset($_POST['m0']))
																{
																	echo'M<input type=hidden name=M0 value=M>';
																}
																if(isset($_POST['t0']))
																{
																	echo'T<input type=hidden name=T0 value=T>';
																}
																if(isset($_POST['w0']))
																{
																	echo'W<input type=hidden name=W0 value=W>';
																}
																if(isset($_POST['th0']))
																{
																	echo'TH<input type=hidden name=TH0 value=TH>';
																}
																if(isset($_POST['f0']))
																{
																	echo'F<input type=hidden name=F0 value=F>';
																}
																if(isset($_POST['s0']))
																{
																	echo'S<input type=hidden name=S0 value=S>';
																}
						echo"</td>
								<td>".$strthr.":".$strtmin." ".$strttypeday."
										<input type=hidden name=strthr0 value=".$strthr.">
										<input type=hidden name=strtmin0 value=".$strtmin.">
										<input type=hidden name=strttypeday0 value=".$strttypeday.">

								</td>
								<td>".$endhr.":".$endmin." ".$endtypeday."
										<input type=hidden name=endhr0 value=".$endhr.">
										<input type=hidden name=endmin0 value=".$endmin.">
										<input type=hidden name=endtypeday0 value=".$endtypeday.">


								</td>
								<td>";
								$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$room");
								$r=mysqli_fetch_array($roomquery);

								echo"".$r['roomname']."/".$r['type']."";

								echo"<input type=hidden name=Room0 value=".$room."></td>



								<td>";
								$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
								$insz=mysqli_fetch_array($insquery);

								echo"".$insz['lname'].",".$insz['gname']."";



								echo"<input type=hidden name=instructor0 value=".$instructor."></td>
								<td>".$remarks."<input type=hidden name=remarks0 value=".$remarks."></td>	
							</tr>";
						
					}





















					if(isset($_POST['classtype1']))
					{
						$classtype=$_POST['classtype1'];

						$strthr=$_POST['strthr1'];
						$strtmin=$_POST['strtmin1'];
						$strttypeday=$_POST['strttypeday1'];

						$endhr=$_POST['endhr1'];
						$endmin=$_POST['endmin1'];
						$endtypeday=$_POST['endtypeday1'];

						$room=$_POST['Room1'];
						$instructor=$_POST['instructor1'];
						$remarks=mysqli_real_escape_string($_POST['remarks1']);
						echo"<tr>
								<td>$classtype <input type=hidden name=classtype1 value=$classtype></td>
								<td>";
																if(isset($_POST['m1']))
																{
																	echo'M<input type=hidden name=M1 value=M>';
																}
																if(isset($_POST['t1']))
																{
																	echo'T<input type=hidden name=T1 value=T>';
																}
																if(isset($_POST['w1']))
																{
																	echo'W<input type=hidden name=W1 value=W>';
																}
																if(isset($_POST['th1']))
																{
																	echo'TH<input type=hidden name=TH1 value=TH>';
																}
																if(isset($_POST['f1']))
																{
																	echo'F<input type=hidden name=F1 value=F>';
																}
																if(isset($_POST['s1']))
																{
																	echo'S<input type=hidden name=S1 value=S>';
																}
						echo"</td>
								<td>".$strthr.":".$strtmin." ".$strttypeday."
										<input type=hidden name=strthr1 value=".$strthr.">
										<input type=hidden name=strtmin1 value=".$strtmin.">
										<input type=hidden name=strttypeday1 value=".$strttypeday.">

								</td>
								<td>".$endhr.":".$endmin." ".$endtypeday."
										<input type=hidden name=endhr1 value=".$endhr.">
										<input type=hidden name=endmin1 value=".$endmin.">
										<input type=hidden name=endtypeday1 value=".$endtypeday.">


								</td>
								<td>";
								$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$room");
								$r=mysqli_fetch_array($roomquery);

								echo"".$r['roomname']."/".$r['type']."";

								echo"<input type=hidden name=Room1 value=".$room."></td>



								<td>";
								$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
								$insz=mysqli_fetch_array($insquery);

								echo"".$insz['lname'].",".$insz['gname']."";



								echo"<input type=hidden name=instructor1 value=".$instructor."></td>
								<td>".$remarks."<input type=hidden name=remarks1 value=".$remarks."></td>	
							</tr>";
						
					}























					if(isset($_POST['classtype2']))
					{
						$classtype=$_POST['classtype2'];

						$strthr=$_POST['strthr2'];
						$strtmin=$_POST['strtmin2'];
						$strttypeday=$_POST['strttypeday2'];

						$endhr=$_POST['endhr2'];
						$endmin=$_POST['endmin2'];
						$endtypeday=$_POST['endtypeday2'];

						$room=$_POST['Room2'];
						$instructor=$_POST['instructor2'];
						$remarks=mysqli_real_escape_string($_POST['remarks2']);
						echo"<tr>
								<td>$classtype <input type=hidden name=classtype2 value=$classtype></td>
								<td>";
																if(isset($_POST['m2']))
																{
																	echo'M<input type=hidden name=M2 value=M>';
																}
																if(isset($_POST['t2']))
																{
																	echo'T<input type=hidden name=T2 value=T>';
																}
																if(isset($_POST['w2']))
																{
																	echo'W<input type=hidden name=W2 value=W>';
																}
																if(isset($_POST['th2']))
																{
																	echo'TH<input type=hidden name=TH2 value=TH>';
																}
																if(isset($_POST['f2']))
																{
																	echo'F<input type=hidden name=F2 value=F>';
																}
																if(isset($_POST['s2']))
																{
																	echo'S<input type=hidden name=S2 value=S>';
																}
						echo"</td>
								<td>".$strthr.":".$strtmin." ".$strttypeday."
										<input type=hidden name=strthr2 value=".$strthr.">
										<input type=hidden name=strtmin2 value=".$strtmin.">
										<input type=hidden name=strttypeday2 value=".$strttypeday.">

								</td>
								<td>".$endhr.":".$endmin." ".$endtypeday."
										<input type=hidden name=endhr2 value=".$endhr.">
										<input type=hidden name=endmin2 value=".$endmin.">
										<input type=hidden name=endtypeday2 value=".$endtypeday.">


								</td>
								<td>";
								$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$room");
								$r=mysqli_fetch_array($roomquery);

								echo"".$r['roomname']."/".$r['type']."";

								echo"<input type=hidden name=Room2 value=".$room."></td>



								<td>";
								$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
								$insz=mysqli_fetch_array($insquery);

								echo"".$insz['lname'].",".$insz['gname']."";



								echo"<input type=hidden name=instructor2 value=".$instructor."></td>
								<td>".$remarks."<input type=hidden name=remarks2 value=".$remarks."></td>	
							</tr>";
						
					}























					if(isset($_POST['classtype3']))
					{
						$classtype=$_POST['classtype3'];

						$strthr=$_POST['strthr3'];
						$strtmin=$_POST['strtmin3'];
						$strttypeday=$_POST['strttypeday3'];

						$endhr=$_POST['endhr3'];
						$endmin=$_POST['endmin3'];
						$endtypeday=$_POST['endtypeday3'];

						$room=$_POST['Room3'];
						$instructor=$_POST['instructor3'];
						$remarks=mysqli_real_escape_string($_POST['remarks3']);
						echo"<tr>
								<td>$classtype <input type=hidden name=classtype3 value=$classtype></td>
								<td>";
																if(isset($_POST['m3']))
																{
																	echo'M<input type=hidden name=M3 value=M>';
																}
																if(isset($_POST['t3']))
																{
																	echo'T<input type=hidden name=T3 value=T>';
																}
																if(isset($_POST['w3']))
																{
																	echo'W<input type=hidden name=W3 value=W>';
																}
																if(isset($_POST['th3']))
																{
																	echo'TH<input type=hidden name=TH3 value=TH>';
																}
																if(isset($_POST['f3']))
																{
																	echo'F<input type=hidden name=F3 value=F>';
																}
																if(isset($_POST['s3']))
																{
																	echo'S<input type=hidden name=S3 value=S>';
																}
						echo"</td>
								<td>".$strthr.":".$strtmin." ".$strttypeday."
										<input type=hidden name=strthr3 value=".$strthr.">
										<input type=hidden name=strtmin3 value=".$strtmin.">
										<input type=hidden name=strttypeday3 value=".$strttypeday.">

								</td>
								<td>".$endhr.":".$endmin." ".$endtypeday."
										<input type=hidden name=endhr3 value=".$endhr.">
										<input type=hidden name=endmin3 value=".$endmin.">
										<input type=hidden name=endtypeday3 value=".$endtypeday.">


								</td>
								<td>";
								$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$room");
								$r=mysqli_fetch_array($roomquery);

								echo"".$r['roomname']."/".$r['type']."";

								echo"<input type=hidden name=Room3 value=".$room."></td>



								<td>";
								$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
								$insz=mysqli_fetch_array($insquery);

								echo"".$insz['lname'].",".$insz['gname']."";



								echo"<input type=hidden name=instructor3 value=".$instructor."></td>
								<td>".$remarks."<input type=hidden name=remarks3 value=".$remarks."></td>	
							</tr>";
						
					}




















					if(isset($_POST['classtype4']))
					{
						$classtype=$_POST['classtype4'];

						$strthr=$_POST['strthr4'];
						$strtmin=$_POST['strtmin4'];
						$strttypeday=$_POST['strttypeday4'];

						$endhr=$_POST['endhr4'];
						$endmin=$_POST['endmin4'];
						$endtypeday=$_POST['endtypeday4'];

						$room=$_POST['Room4'];
						$instructor=$_POST['instructor4'];
						$remarks=mysqli_real_escape_string($_POST['remarks4']);
						echo"<tr>
								<td>$classtype <input type=hidden name=classtype4 value=$classtype></td>
								<td>";
																if(isset($_POST['m4']))
																{
																	echo'M<input type=hidden name=M4 value=M>';
																}
																if(isset($_POST['t4']))
																{
																	echo'T<input type=hidden name=T4 value=T>';
																}
																if(isset($_POST['w4']))
																{
																	echo'W<input type=hidden name=W4 value=W>';
																}
																if(isset($_POST['th4']))
																{
																	echo'TH<input type=hidden name=TH4 value=TH>';
																}
																if(isset($_POST['f4']))
																{
																	echo'F<input type=hidden name=F4 value=F>';
																}
																if(isset($_POST['s4']))
																{
																	echo'S<input type=hidden name=S4 value=S>';
																}
						echo"</td>
								<td>".$strthr.":".$strtmin." ".$strttypeday."
										<input type=hidden name=strthr4 value=".$strthr.">
										<input type=hidden name=strtmin4 value=".$strtmin.">
										<input type=hidden name=strttypeday4 value=".$strttypeday.">

								</td>
								<td>".$endhr.":".$endmin." ".$endtypeday."
										<input type=hidden name=endhr4 value=".$endhr.">
										<input type=hidden name=endmin4 value=".$endmin.">
										<input type=hidden name=endtypeday4 value=".$endtypeday.">


								</td>
								<td>";
								$roomquery=mysqli_query("SELECT * FROM roomstbl where ctr=$room");
								$r=mysqli_fetch_array($roomquery);

								echo"".$r['roomname']."/".$r['type']."";

								echo"<input type=hidden name=Room4 value=".$room."></td>



								<td>";
								$insquery=mysqli_query("SELECT * FROM staff where ctr=$instructor");
								$insz=mysqli_fetch_array($insquery);

								echo"".$insz['lname'].",".$insz['gname']."";



								echo"<input type=hidden name=instructor4 value=".$instructor."></td>
								<td>".$remarks."<input type=hidden name=remarks4 value=".$remarks."></td>	
							</tr>";
						
					}
























































				}
		?>
		<tr foot>
			<td><input type="submit" name="step3" value="POST SCHEDULE"></td>
			<td><a href="index.php" buttonlike>Cancel</a></td>
			<td colspan='5'></td>
		</tr>




	</table>

</form>
<br>
	<div style="float:left;margin-left:200px;">
	</div>
</div>
</div>
</body>
</html>





























<?php
if(isset($_POST['step3']))
{
	$cid=$_POST['courseid'];
	$termid=$_POST['term'];










	if(isset($_POST['classtype0']))
	{
		$classtype=$_POST['classtype0'];

		if(isset($_POST['M0'])){$monday=1;}
			else{$monday=0;}
		if(isset($_POST['T0'])){$tuesday=1;}
			else{$tuesday=0;}
		if(isset($_POST['W0'])){$wednesday=1;}
			else{$wednesday=0;}		
		if(isset($_POST['TH0'])){$thursday=1;}
			else{$thursday=0;}
		if(isset($_POST['F0'])){$friday=1;}
			else{$friday=0;}
		if(isset($_POST['S0'])){$sabado=1;}
			else{$sabado=0;}				

		$strthr=$_POST['strthr0'];
		$strtmin=$_POST['strtmin0'];
		$strttypeday=$_POST['strttypeday0'];
		$endhr=$_POST['endhr0'];
		$endmin=$_POST['endmin0'];
		$endtypeday=$_POST['endtypeday0'];

		$room=$_POST['Room0'];
		$instructor=$_POST['instructor0'];
		$remarks=mysqli_real_escape_string($_POST['remarks0']);

		$mynumber=0;



		$addsched=mysqli_query("INSERT INTO schedule
			(
				courseid,
				term,
				m,
				t,
				w,
				th,
				f,
				s,
				starthr,
				startmin,
				starttypeday,
				endhr,
				endmin,
				endtypeday,
				room,
				instructor,
				classtype,
				remarks,
				mynumber
			) 
			values
			(
				$cid,
				$termid,
				$monday,
				$tuesday,
				$wednesday,
				$thursday,
				$friday,
				$sabado,
				$strthr,
				$strtmin,
				'$strttypeday',
				$endhr,
				$endmin,
				'$endtypeday',
				$room,
				$instructor,
				'$classtype',
				'$remarks',
				$mynumber
			)
		");

	}













if(isset($_POST['classtype1']))
	{
		$classtype=$_POST['classtype1'];

		if(isset($_POST['M1'])){$monday=1;}
			else{$monday=0;}
		if(isset($_POST['T1'])){$tuesday=1;}
			else{$tuesday=0;}
		if(isset($_POST['W1'])){$wednesday=1;}
			else{$wednesday=0;}		
		if(isset($_POST['TH1'])){$thursday=1;}
			else{$thursday=0;}
		if(isset($_POST['F1'])){$friday=1;}
			else{$friday=0;}
		if(isset($_POST['S1'])){$sabado=1;}
			else{$sabado=0;}				

		$strthr=$_POST['strthr1'];
		$strtmin=$_POST['strtmin1'];
		$strttypeday=$_POST['strttypeday1'];
		$endhr=$_POST['endhr1'];
		$endmin=$_POST['endmin1'];
		$endtypeday=$_POST['endtypeday1'];

		$room=$_POST['Room1'];
		$instructor=$_POST['instructor1'];
		$remarks=mysqli_real_escape_string($_POST['remarks1']);

		$mynumber=1;



		$addsched=mysqli_query("INSERT INTO schedule
			(
				courseid,
				term,
				m,
				t,
				w,
				th,
				f,
				s,
				starthr,
				startmin,
				starttypeday,
				endhr,
				endmin,
				endtypeday,
				room,
				instructor,
				classtype,
				remarks,
				mynumber
			) 
			values
			(
				$cid,
				$termid,
				$monday,
				$tuesday,
				$wednesday,
				$thursday,
				$friday,
				$sabado,
				$strthr,
				$strtmin,
				'$strttypeday',
				$endhr,
				$endmin,
				'$endtypeday',
				$room,
				$instructor,
				'$classtype',
				'$remarks',
				$mynumber
			)
		");

	}







if(isset($_POST['classtype2']))
	{
		$classtype=$_POST['classtype2'];

		if(isset($_POST['M2'])){$monday=1;}
			else{$monday=0;}
		if(isset($_POST['T2'])){$tuesday=1;}
			else{$tuesday=0;}
		if(isset($_POST['W2'])){$wednesday=1;}
			else{$wednesday=0;}		
		if(isset($_POST['TH2'])){$thursday=1;}
			else{$thursday=0;}
		if(isset($_POST['F2'])){$friday=1;}
			else{$friday=0;}
		if(isset($_POST['S2'])){$sabado=1;}
			else{$sabado=0;}				

		$strthr=$_POST['strthr2'];
		$strtmin=$_POST['strtmin2'];
		$strttypeday=$_POST['strttypeday2'];
		$endhr=$_POST['endhr2'];
		$endmin=$_POST['endmin2'];
		$endtypeday=$_POST['endtypeday2'];

		$room=$_POST['Room2'];
		$instructor=$_POST['instructor2'];
		$remarks=mysqli_real_escape_string($_POST['remarks2']);

		$mynumber=2;



		$addsched=mysqli_query("INSERT INTO schedule
			(
				courseid,
				term,
				m,
				t,
				w,
				th,
				f,
				s,
				starthr,
				startmin,
				starttypeday,
				endhr,
				endmin,
				endtypeday,
				room,
				instructor,
				classtype,
				remarks,
				mynumber
			) 
			values
			(
				$cid,
				$termid,
				$monday,
				$tuesday,
				$wednesday,
				$thursday,
				$friday,
				$sabado,
				$strthr,
				$strtmin,
				'$strttypeday',
				$endhr,
				$endmin,
				'$endtypeday',
				$room,
				$instructor,
				'$classtype',
				'$remarks',
				$mynumber
			)
		");

	}


	if(isset($_POST['classtype3']))
	{
		$classtype=$_POST['classtype3'];

		if(isset($_POST['M3'])){$monday=1;}
			else{$monday=0;}
		if(isset($_POST['T3'])){$tuesday=1;}
			else{$tuesday=0;}
		if(isset($_POST['W3'])){$wednesday=1;}
			else{$wednesday=0;}		
		if(isset($_POST['TH3'])){$thursday=1;}
			else{$thursday=0;}
		if(isset($_POST['F3'])){$friday=1;}
			else{$friday=0;}
		if(isset($_POST['S3'])){$sabado=1;}
			else{$sabado=0;}				

		$strthr=$_POST['strthr3'];
		$strtmin=$_POST['strtmin3'];
		$strttypeday=$_POST['strttypeday3'];
		$endhr=$_POST['endhr3'];
		$endmin=$_POST['endmin3'];
		$endtypeday=$_POST['endtypeday3'];

		$room=$_POST['Room3'];
		$instructor=$_POST['instructor3'];
		$remarks=mysqli_real_escape_string($_POST['remarks3']);

		$mynumber=3;



		$addsched=mysqli_query("INSERT INTO schedule
			(
				courseid,
				term,
				m,
				t,
				w,
				th,
				f,
				s,
				starthr,
				startmin,
				starttypeday,
				endhr,
				endmin,
				endtypeday,
				room,
				instructor,
				classtype,
				remarks,
				mynumber
			) 
			values
			(
				$cid,
				$termid,
				$monday,
				$tuesday,
				$wednesday,
				$thursday,
				$friday,
				$sabado,
				$strthr,
				$strtmin,
				'$strttypeday',
				$endhr,
				$endmin,
				'$endtypeday',
				$room,
				$instructor,
				'$classtype',
				'$remarks',
				$mynumber
			)
		");

	}




	if(isset($_POST['classtype4']))
	{
		$classtype=$_POST['classtype4'];

		if(isset($_POST['M4'])){$monday=1;}
			else{$monday=0;}
		if(isset($_POST['T4'])){$tuesday=1;}
			else{$tuesday=0;}
		if(isset($_POST['W4'])){$wednesday=1;}
			else{$wednesday=0;}		
		if(isset($_POST['TH4'])){$thursday=1;}
			else{$thursday=0;}
		if(isset($_POST['F4'])){$friday=1;}
			else{$friday=0;}
		if(isset($_POST['S4'])){$sabado=1;}
			else{$sabado=0;}				

		$strthr=$_POST['strthr4'];
		$strtmin=$_POST['strtmin4'];
		$strttypeday=$_POST['strttypeday4'];
		$endhr=$_POST['endhr4'];
		$endmin=$_POST['endmin4'];
		$endtypeday=$_POST['endtypeday4'];

		$room=$_POST['Room4'];
		$instructor=$_POST['instructor4'];
		$remarks=mysqli_real_escape_string($_POST['remarks4']);

		$mynumber=4;



		$addsched=mysqli_query("INSERT INTO schedule
			(
				courseid,
				term,
				m,
				t,
				w,
				th,
				f,
				s,
				starthr,
				startmin,
				starttypeday,
				endhr,
				endmin,
				endtypeday,
				room,
				instructor,
				classtype,
				remarks,
				mynumber
			) 
			values
			(
				$cid,
				$termid,
				$monday,
				$tuesday,
				$wednesday,
				$thursday,
				$friday,
				$sabado,
				$strthr,
				$strtmin,
				'$strttypeday',
				$endhr,
				$endmin,
				'$endtypeday',
				$room,
				$instructor,
				'$classtype',
				'$remarks',
				$mynumber
			)
		");

	}










	echo'<script type="text/javascript">alert("SUCCESSFULY ADDED");</script>';
	echo'<script language="JavaScript"> window.location.href ="viewsched.php?id='.$cid.'"</script>';
}
?>