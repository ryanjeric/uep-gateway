<style>
[d1]
{
margin:auto;
margin-top:2%;
background:maroon;
height:100px;
padding:10px;
width:90%;
color:white;
font-size:16px;
border-bottom:10px solid #EECD86;
box-shadow:0 2px 5px #3D3242;
margin-bottom:2%;
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
	<img src='redstar.png' logo />
	<abbr uep>UEP</abbr>
	<span id='gateway'>REGISTRAR'S GATEWAY</span>
	<div id='below'> 
		<span university>UNIVERSITY of EASTERN PANGASINAN</span>
		
		<span log>
			Time: <span id="txt" time></span> |
			<a href='../logout.php' logout>LOGOUT</a> 
		</span>
	</div>
<br>
</div>