<html>
<body>
<form name=form1 method=POST>
To: <input type=text name=to /><br>
Message: <input type=text name=sms /> <br>
<input type=submit value=SEND name=send />
</form>
</body>
</html>
<?php
if(isset($_POST['send']))
{
$to_cno = $_POST['to']; 
$message=$_POST['sms'];
$sender="UEP";
$url='http://localhost:9333/ozeki?';
$url.="action=sendMessage";
$url.="&login=admin";
$url.="&password=abc123";
$url.="&recepient=".urlencode($to_cno);
$url.="&messageData=".urlencode($message);
$url.="&sender=".urlencode($sender);
file($url);
echo "Message sent";
}
?>