<?php
error_reporting(0);
/* These are the variable that tell the subject of the email and where the email will be sent.*/

$emailSubject = 'GeTogether response section!';
$mailto = 'kushwaharesonance@gmail.com';

/* These will gather what the user has typed into the fieled. */

$nameField = $_POST['name'];
$emailField = $_POST['email'];
$questionField = $_POST['question'];
$phoneField = $_POST['phone'];

/* This takes the information and lines it up the way you want it to be sent in the email. */

$body = <<<EOD
<br><hr><br>
Name: $nameField <br>
Email: $emailField <br>
Phone: $phoneField<br>
Question: $questionField <br>
EOD;

$headers = "From: $emailField\r\n"; // This takes the email and displays it as who this email is from.
$headers .= "Content-type: text/html\r\n"; // This tells the server to turn the coding into the text.
$success = mail($mailto, $emailSubject, $body, $headers); // This tells the server what to send.
if($success)
	{   echo "<script>alert('message sent successfully')</script>";
		echo "<script>window.open('contactus.php','_self')</script>";
	}
	else
	{
		echo "<script>alert('message not sent!')</script>";
		echo "<script>window.open('contactus.php','_self')</script>";
	}
?>