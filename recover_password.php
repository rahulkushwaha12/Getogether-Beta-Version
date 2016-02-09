<?php include ("./inc/header.inc.php");
error_reporting(0);
?>
<?php
echo '<div style="height:40px; width:100%;"></div>';
?>
<?php
error_reporting(0);

$get_id = mysql_real_escape_string(@$_GET['recover_num']);
$get_user = $get_id;
$len = strlen($get_user);
$get_user =  substr($get_user,15,$len);
$username = $get_user;
?>
<?php

 $senddata = @$_POST['senddata'];
//password variables
//$old_password = strip_tags(@$_POST['oldpassword']);
$new_password = strip_tags(@$_POST['newpassword']);
$repeat_password = strip_tags(@$_POST['newpassword2']);

if($senddata)
{
	if( $new_password == "" && $repeat_password == ""){
	echo "please enter some data!";
	}
	else{
//if the form has been submitted...
$password_query = mysql_query("SELECT * FROM users WHERE username='$username'");
while($row = mysql_fetch_assoc($password_query)){
//$db_password = $row['password'];
//md5 the old password before ve check if it matches
//$old_password_md5 = md5($old_password);
//check whether old password equals $db_password
//if($old_password_md5 == $db_password)
//continue changing the users password...
//check whether the 2 passwords match
if($new_password == $repeat_password){
	if(strlen($new_password)<=4){
		echo "Sorry! your password must be more than 4 characters long!";
		}
	else{
//md5 the new password before ve add it to database
$new_password_md5 = md5($new_password);
//Great! update the users passwords!
$password_update_query = mysql_query("UPDATE users SET password = '$new_password_md5' WHERE username='$username'");
echo "Success! Your password has been updated!";
}}
else
{
echo "Your two new passwords don't match!";
}

}
	}}
else
{
echo "";
}



?>

<form action="recover_password.php" method="post">
<p>CHANGE YOUR PASSWORD FOR USERNAME:(<?php echo $username; ?>)</p><br />

Your New Password: <input type="password" name="newpassword" id="newpassword" size="40"><br />
Re-type New Password: <input type="password" name="newpassword2" id="newpassword2" size="40"><br />

<input type="submit" name="senddata" id="senddata" value="recover">
</form>