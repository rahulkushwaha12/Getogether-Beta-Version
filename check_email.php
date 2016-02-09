<?php include ("./inc/header.inc.php");
error_reporting(0);?>
<?php
echo '<div style="height:40px; width:100%;"></div>';
?>
<?php
error_reporting(0);

$get_id = mysql_real_escape_string(@$_GET['checkid']);
$query = mysql_query("SELECT * FROM users WHERE id = '$get_id'");
$rows = mysql_num_rows($query);
$get = mysql_fetch_assoc($query);
$username = $get['username'];
$email = $get['email'];
$firstname = $get['first_name'];
$lastname = $get['last_name'];
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name = substr(str_shuffle($chars), 0, 15);

$link = $rand_dir_name.$username;

//$link = $link.g.$get_id.t;


if($rows == 0){
	echo"
	<center>
	 ERROR 404 !
	<br />
	Before you begin with that sql injection.
	<br />
	your ip address is being noted down.
	<br />
	and we will get back you soon.
	</center>
	";	

}
else{
/* These are the variable that tell the subject of the email and where the email will be sent.*/

$emailSubject = 'Forgot password!';
$mailto = $email;

/* These will gather what the user has typed into the fieled. */

//$nameField = $_POST['name'];
//$emailField = $_POST['email'];
//$questionField = $_POST['question'];
//$phoneField = $_POST['phone'];

/* This takes the information and lines it up the way you want it to be sent in the email. */

$body = <<<EOD
echo "<br><hr><br>
HI, <br>
$firstname $lastname <br>
It seems that you have just requested us to revover your password. <br>
we will definitely help you to recover it. <br>
click on this link below or copy and paste it in new tab in your browser for further processing. <br>

<h3> http://getogether.net46.net/recover_password.php?recover_num=$link </h3><br>
<hr>
If you are seeing this by mistake. <br>
Please disregard this mail. <br>
<br>
Regards, Getogether Security Team !!!

";
EOD;

$headers = "From: security_team@getogether.com\r\n"; // This takes the email and displays it as who this email is from.
$headers .= "Content-type: text/html\r\n"; // This tells the server to turn the coding into the text.
$success = mail($mailto, $emailSubject, $body, $headers); // This tells the server what to send.
if($success)
	{   echo "A link has been sent to your inbox....check your email for further processing!";
		
	}
	else
	{
		header("location: forgot.php");
	}
}?>

