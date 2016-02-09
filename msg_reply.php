<?php
error_reporting(0);
include ("./inc/header.inc.php");
echo '<div style="height:40px; width:100%;"></div>';

if(isset($_GET['u'])){
$username1 = mysql_real_escape_string($_GET['u']);
if(ctype_alnum($username1)){
//check user exists
$check = mysql_query("SELECT username, first_name FROM users WHERE username='$username1'");
if(mysql_num_rows($check)===1){
	$get = mysql_fetch_assoc($check);
	
	$firstname = $get['first_name'];
	$username1 = $get['username'];
	//check user isn't sending themselves a private msg
if($username1 != $username){
	if(isset($_POST['submit'])){
		$msg_title = "open";
		$msg_body = mysql_real_escape_string(@$_POST['msg_body']);
   		date_default_timezone_set('Asia/Calcutta');
        $date = date('Y/m/d H:i:s');
		//$date = date("Y-m-d");
		$opened = "no";
		$deleted = "no";
		if($msg_title == ""){
echo "Please give your message a title.";
}
		else if($msg_body == ""){
echo "Please write a message.";
}
else{
		$send_msg = mysql_query("INSERT INTO pvt_messages VALUES ('','$username','$username1','$msg_title','$msg_body','$date','$opened', '$deleted')") or die("error");
echo "Your message has been sent!";
}
}

echo"
<form action='msg_reply.php?u=$username1' method='POST'>
<h2>Compose a Message:($username1)</h2>

<textarea cols='59' rows='6' name='msg_body' placeholder='enter your message here'></textarea><p />
<input type='submit' name='submit' value='Send Message'>
</form>

";

}
else
{
header("Location: $username");
}
	} 
}
}

?>