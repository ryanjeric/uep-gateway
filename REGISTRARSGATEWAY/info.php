<style>
[d1]
{
margin:2% auto;
background:maroon;
height:100px;
padding:10px;
width:90%;
color:white;
font-size:16px;
border-bottom:10px solid #EECD86;
box-shadow:0 2px 5px #3D3242;
}
	abbr[uep]{
	float:left;
	font-size:40px;
	width:30%;
	margin-left:10px;
	border-bottom:1px solid white;
	letter-spacing:5px;
	}
	span#gateway {
	display:inline-block;
	float:left;
	font-size:40px;
	width:60%;
	height:50px;
	text-align:right
	}
	div#below {
	display:inline-block;
	margin-left:10px;
	width:90%;
	}

		[logo] {
			display:inline-block;
			float:left;
			height:100px;
			width:auto;
			border:5px solid white;
			box-shadow:0 2px 5px black;
			border-radius:5px;
			margin:0;
		}
		
span[university] {
display:inline-block;
width:40%;
font-size:17.5px;
}
span[log]{
display:inline-block;
float:right;
width:50%;
text-align:right;
}
a[logout] {
color:#EECD86;
}
</style>
<div d1>
	<a href='../REGISTRARSGATEWAY'><img src='redstar.png' logo /></a>
	<abbr uep>UEP</abbr>
	<span id='gateway'>REGISTRAR'S GATEWAY</span>
	<div id='below'> 
		<span university>UNIVERSITY of EASTERN PANGASINAN</span>
		
		<span log>
			Year Term :<?php echo' <u>'.$rows["syear"].' '.$rows["sem"].'</u>' ?> /
			<a href=chooseterm.php style="color:yellowgreen">Change</a>			|
			Time: <span id="txt" time></span> |
			<a href='logout.php' logout>LOGOUT</a>  <br>
			LOGGED: 
			<?php
			 echo''.$row["lname"].' , '.$row["gname"].''; 
			 echo" on " . date("Y/m/d");
			 
			 $inactive = 600; // Set timeout period in seconds

				if (isset($_SESSION['timeout'])) {
					$session_life = time() - $_SESSION['timeout'];
					if ($session_life > $inactive) {
						session_destroy();
						header("Location: logout.php");
					}
				}
				$_SESSION['timeout'] = time();
			 
			 ?>
		</span>
	</div>
<br>
</div>


