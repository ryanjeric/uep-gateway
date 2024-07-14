<?php
include('conn.php');
if(isset($_POST['updatesched']))
{
	$cid=$_POST['courseid'];
	$termid=$_POST['term'];
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$query0=mysqli_query("SELECT * FROM schedule where courseid=$cid and term=$termid and mynumber=0");
	$count0=mysqli_num_rows($query0);
	$query1=mysqli_query("SELECT * FROM schedule where courseid=$cid and term=$termid and mynumber=1");
	$count1=mysqli_num_rows($query1);
	$query2=mysqli_query("SELECT * FROM schedule where courseid=$cid and term=$termid and mynumber=2");
	$count2=mysqli_num_rows($query2);
	$query3=mysqli_query("SELECT * FROM schedule where courseid=$cid and term=$termid and mynumber=3");
	$count3=mysqli_num_rows($query3);
	$query4=mysqli_query("SELECT * FROM schedule where courseid=$cid and term=$termid and mynumber=4");
	$count4=mysqli_num_rows($query4);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['classtype0']))
{
	if($_POST['classtype0']=="wew" and $count0==1)
	{
		mysqli_query("DELETE FROM schedule where term=$termid and courseid=$cid and mynumber=0");
	}
	elseif($_POST['classtype0']=="LEC" and $count0==1 or $_POST['classtype0']=="LAB" and $count0==1)
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

			$query="UPDATE schedule SET 
				classtype='$classtype',
				 m=$monday,
				 t=$tuesday,
				 w=$wednesday,
				 th=$thursday,
				 f=$friday,
				 s=$sabado,
				 starthr=$strthr,
				 startmin=$strtmin,
				 starttypeday='$strttypeday',
				 endhr=$endhr,
				 endmin=$endmin,
				 endtypeday='$endtypeday',
				 room=$room,
				 instructor=$instructor,
				 remarks='$remarks'
				  WHERE courseid=$cid and term=$termid and mynumber=$mynumber";
				$r=mysqli_query($query);
	}
	elseif($_POST['classtype0']=="LEC" and $count0==0 or $_POST['classtype0']=="LAB" and $count0==0)
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
	}}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['classtype1']))
{
	if($_POST['classtype1']=="wew" and $count1==1)
	{
		mysqli_query("DELETE FROM schedule where term=$termid and courseid=$cid and mynumber=1");
	}
	elseif($_POST['classtype1']=="LEC" and $count1==1 or $_POST['classtype1']=="LAB" and $count1==1)
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


			$query="UPDATE schedule SET 
				classtype='$classtype',
				 m=$monday,
				 t=$tuesday,
				 w=$wednesday,
				 th=$thursday,
				 f=$friday,
				 s=$sabado,
				 starthr=$strthr,
				 startmin=$strtmin,
				 starttypeday='$strttypeday',
				 endhr=$endhr,
				 endmin=$endmin,
				 endtypeday='$endtypeday',
				 room=$room,
				 instructor=$instructor,
				 remarks='$remarks'
				  WHERE courseid=$cid and term=$termid and mynumber=$mynumber";
				$r=mysqli_query($query);
	}
	elseif($_POST['classtype1']=="LEC" and $count1==0 or $_POST['classtype1']=="LAB" and $count1==0)
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
	}}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['classtype2']))
{
	if($_POST['classtype2']=="wew" and $count2==1)
	{
		mysqli_query("DELETE FROM schedule where term=$termid and courseid=$cid and mynumber=2");
	}
	elseif($_POST['classtype2']=="LEC" and $count2==1 or $_POST['classtype2']=="LAB" and $count2==1)
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


			$query="UPDATE schedule SET 
			classtype='$classtype',
			 m=$monday,
			 t=$tuesday,
			 w=$wednesday,
			 th=$thursday,
			 f=$friday,
			 s=$sabado,
			 starthr=$strthr,
			 startmin=$strtmin,
			 starttypeday='$strttypeday',
			 endhr=$endhr,
			 endmin=$endmin,
			 endtypeday='$endtypeday',
			 room=$room,
			 instructor=$instructor,
			 remarks='$remarks'
			  WHERE courseid=$cid and term=$termid and mynumber=$mynumber";
			$r=mysqli_query($query);
	}
	elseif($_POST['classtype2']=="LEC" and $count2==0 or $_POST['classtype2']=="LAB" and $count2==0)
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
	}}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['classtype3']))
{
	if($_POST['classtype3']=="wew" and $count3==1)
	{
		mysqli_query("DELETE FROM schedule where term=$termid and courseid=$cid and mynumber=3");
	}
	elseif($_POST['classtype3']=="LEC" and $count3==1 or $_POST['classtype3']=="LAB" and $count3==1)
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


			$query="UPDATE schedule SET 
				classtype='$classtype',
				 m=$monday,
				 t=$tuesday,
				 w=$wednesday,
				 th=$thursday,
				 f=$friday,
				 s=$sabado,
				 starthr=$strthr,
				 startmin=$strtmin,
				 starttypeday='$strttypeday',
				 endhr=$endhr,
				 endmin=$endmin,
				 endtypeday='$endtypeday',
				 room=$room,
				 instructor=$instructor,
				 remarks='$remarks'
				  WHERE courseid=$cid and term=$termid and mynumber=$mynumber";
				$r=mysqli_query($query);
	}
	elseif($_POST['classtype3']=="LEC" and $count3==0 or $_POST['classtype3']=="LAB" and $count3==0)
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
	}}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['classtype4']))
{
	if($_POST['classtype4']=="wew" and $count4==1)
	{
		mysqli_query("DELETE FROM schedule where term=$termid and courseid=$cid and mynumber=4");
	}
	elseif($_POST['classtype4']=="LEC" and $count4==1 or $_POST['classtype4']=="LAB" and $count4==1)
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


			$query="UPDATE schedule SET 
				classtype='$classtype',
				 m=$monday,
				 t=$tuesday,
				 w=$wednesday,
				 th=$thursday,
				 f=$friday,
				 s=$sabado,
				 starthr=$strthr,
				 startmin=$strtmin,
				 starttypeday='$strttypeday',
				 endhr=$endhr,
				 endmin=$endmin,
				 endtypeday='$endtypeday',
				 room=$room,
				 instructor=$instructor,
				 remarks='$remarks'
				  WHERE courseid=$cid and term=$termid and mynumber=$mynumber";
				$r=mysqli_query($query);
	}
	elseif($_POST['classtype4']=="LEC" and $count4==0 or $_POST['classtype4']=="LAB" and $count4==0)
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
	}}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo'<script type="text/javascript">alert("UPDATE SUCCESSFULL");</script>';
					echo'<script language="JavaScript"> window.location.href ="viewsched.php?id='.$cid.'" </script>';
}
else
		{
			header("Location: index.php");
		}
?>