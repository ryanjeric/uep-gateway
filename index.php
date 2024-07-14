<!DOCTYPE HTML>
<html>
<head>
<title>UEP - GATEWAY</title>
<style>
* {margin:0; padding:0;}
table {
background:maroon;
width:1000px;
margin:2% auto;
padding:10px;;
box-shadow:0 2px 5px black;
}
td {
vertical-align:Top;
text-align:center;
color:white;
font-size:40px;
}
td[left] {
	width:30%;
}
	[logo] {
	width:150px;
	height:200px;
	}
td[right] {
	font-size:50px;
}
	abbr {
		font-size:100px;
		font-weight:bold;
		letter-spacing:10px;
	}

	hr {
    padding: 0;
    border: none;
    border-top: medium double white;
    color: white
    text-align: center;
	font-size:.1em;
	}

	
div[wrap] {
display:flex;
width:1000px;
margin:auto;
height:250px;
text-align:center;
background:white;
}

[gateway] {
display:inline-block;
width:150px;
background:white;
margin:20px auto;
box-shadow:inset 0 2px 5px #333;
border:5px solid #B95835;
border-radius:3px;
overflow:hidden;
}

[open]{
background:#E18942;
height:200px;
transition:all ease 1s;
cursor:pointer;
font-size:16px;
}

[open]:hover {
margin-left:-12px;
margin-top:-2px;
transform: perspective( 300px ) rotateY( 30deg ) scale(0.86);
transition:all ease-in-out .5s;
border-width:4px 3px 4px 0;
border-style:solid;
border-color:#333;

}

a {
display:inline-block;
width:100%; height:100%;
text-decoration:none;
color:maroon;
}

span[circle] {
display:inline-block;
width:25px; height:25px;
background:white;
border:3px solid black;
border-radius:50%;
box-shadow:inset 0 2px 2px #333;
}

span[letter] {
font-size:60px;
font-weight:bold;
}
</style>
</head>
<body>

<table>
<tr>
<td left><img src='redstar.png' logo></td>
<td right><abbr>UEP</abbr> <hr> 
University of Eastern Pangasinan <hr></td>
</tr>


<tr>
<td colspan='2'>
<div wrap>
<div gateway><div open><a href='REGISTRARSGATEWAY'><Br>REGISTRARS <Br> GATEWAY <br> <span circle></span><br><span letter>R</span></a></div></div>
<div gateway><div open><a href='DEANSGATEWAY'><br>DEANS <Br> GATEWAY<br><span circle></span><br><span letter>D</span></a></div></div>
<div gateway><div open><a href='INSTRUCTORSGATEWAY'><Br>INSTRUCTORS <br> GATEWAY<Br><span circle></span><br><span letter>I</span></a></div></div>
</div>
</td>
</tr>
</tr><td colspan='2'>GATEWAYS</td></tr>
</table>

</body>





</html>