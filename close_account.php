<?php

include("./inc/header.inc.php");
error_reporting(0);
if($username){
	echo '<div style="height:40px; width:100%;"></div>';
if(isset($_POST['no'])){
header("Location: account_settings.php");
}
if(isset($_POST['yes'])){
$query = mysql_query("UPDATE users SET closed = 'yes' WHERE username = '$username'");
echo "Your Account has been closed!";
session_destroy();}
}

else{
	echo '<div style="height:40px; width:100%;"></div>';
die ("You must be logged in to view this page!");
}
?>
<br />
<center>
<form action="close_account.php" method = "POST">
Are you sure you want to close your account?<br>
<input type="submit" name="no" value="No, take me back!">
<input type="submit" name="yes" value="Yes I'm sure">
</form>
</center>