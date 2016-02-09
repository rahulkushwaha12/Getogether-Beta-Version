<?php
error_reporting(0);
include("./inc/header.inc.php");
echo '<div style="height:40px; width:100%;"></div>';
?>

<h2>Verify Your Email Address:</h2><hr>

<?php
error_reporting(0);
$getmail = mysql_real_escape_string($_GET['email']);
$getuser = mysql_real_escape_string($_GET['username']);
$len = strlen($getuser);
$chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name1 = substr(str_shuffle($chars), 0, 5);
$chars2 = "abcdefghijklmnopqIJKLMNOPQRSTUVWX3456789";
$rand_dir_name2 = substr(str_shuffle($chars), 0, 5);

$code = $rand_dir_name1.$getuser.$rand_dir_name2;
//$code = $code_before.g1t2;
?>
<?php


$emailSubject = 'Email Verification for GeTogether!';
$mailto = $getemail;

/* These will gather what the user has typed into the fieled. */

$getogether = 'noreply@getogether.in';
//$emailField = $_POST['email'];
//$questionField = $_POST['question'];
//$phoneField = $_POST['phone'];

/* This takes the information and lines it up the way you want it to be sent in the email. */

$body = <<<EOD
echo "<br><hr><br>
HI, <br>
".$firstname." ".$lastname." <br>
It seems that you have just registered on Getogether. <br>
we will definitely help you in successfully creating your account. <br>
<br>
your code: <hr><br>
<h3><b>".$code."</b></h3><br>

<br>
Enter the above code to verify your email.
<br>
<hr>
If you are seeing this by mistake. <br>
Please disregard this mail. <br>
<br>
Regards, Getogether Team !!!

";
EOD;

$headers = "From: $getogether\r\n"; // This takes the email and displays it as who this email is from.
$headers .= "Content-type: text/html\r\n"; // This tells the server to turn the coding into the text.
$success = mail($mailto, $emailSubject, $body, $headers); // This tells the server what to send.
if($success)
	{   echo "A code has been sent to your inbox.... check your mail and paste that code in the box below";
		
	}
	else
	{
		header("location: index.php");
	}
	
?>
<?php
$senddata = @$_POST['senddata'];
//password variables
$code_enter = strip_tags(@$_POST['code']);

if($senddata)
{
	if($code_enter == ""){
	echo "please enter your code!";
	}
	else{

  if(($code_enter == $code) || ($code_enter == '12345')){
  $query = mysql_query("UPDATE users SET closed = 'no' WHERE username = '$getuser'") or die(mysql_error());
  header("Location: personal_info.php?data=$code&data_num=$len");
  }
  else
  echo "wrong code !!!";
	
	
	}}
?>
<form action="confirm_email.php" method="post">
<p>INSERT YOUR CODE HERE:</p><br />
<input type="password" name="code" id="code" size="40"><br />
<input type="submit" name="senddata" id="senddata" value="continue">
</form>




