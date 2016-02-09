
<?php include ("./inc/header.inc.php");
error_reporting(0);?>
<?php
echo '<div style="height:40px; width:100%;"></div>';
$reg = @$_POST['reg'];
//declaring variables to prevent errors
$fn = "";//first name
$ln = "";//last name
$un = "";//user name
$em = "";//email
$em2 = "";//email2
$pswd = "";//passowrd
$pswd2 = "";//password2
$d = "";//sign up date
$u_check = "";//check if username exists
//registration form
$fn =strip_tags(@$_POST['fname']);
$ln =strip_tags(@$_POST['lname']);
$un =strip_tags(@$_POST['username']);
$em =strip_tags(@$_POST['email']);
$em2 =strip_tags(@$_POST['email2']);
$pswd =strip_tags(@$_POST['password']);
$pswd2 =strip_tags(@$_POST['password2']);
$d =date("Y-m-d");//year-month-day

if($reg){
if($em==$em2){
//check if the user already exists
$u_check = mysql_query("SELECT username FROM users WHERE username='$un'");
//count the amount of rows where username= $un
$check = mysql_num_rows($u_check);

//check whether email already exists in the database
$e_check = mysql_query("SELECT email FROM users WHERE email='$em'");
//count the number of rows returned
$email_check = mysql_num_rows($e_check);
if($check == 0){
if($email_check == 0){


//check all of the fields have been filled in
if($fn&&$ln&&$un&&$em&&$em2&&$pswd&&$pswd2){
// check that passwords match
if($pswd==$pswd2){
// check the maximum length of username/firstname/lastname does not exceed 25 characters
if(strlen($un)>25||strlen($fn)>25||strlen($ln)>25){
echo "The maximum limit for username/first name/last name is 25 characters!";
}
else
{
// check the maximum length of password does not exceed 25 characters and is not less than 5 characters
if(strlen($pswd)>30||strlen($pswd)<5){
echo "your password must be between 5 and 30 characters long!";
}
else
{
// encrypt password and password2 using md5 before sending to database
$pswd = md5($pswd);
$pswd2 = md5($pswd2);
$query = mysql_query("INSERT INTO users VALUES ('','','','','','','','','','','','$un','$fn','$ln','$em','$pswd','$d','','','','','','no')");
//die("<h2>Welcome to GeTogether</h2>Login to your account to get started ...");
$len = strlen($un);
$code = $un;
header("Location: personal_info.php?data=$code&data_num=$len");
//header("Location: confirm_email.php?email=$em&username=$un");
}
}
}
else{
echo "Your passwords don't match!";
}
}
else
{
echo "Please fill in all of the fields";
}
}
else{
echo "Sorry, but it looks like someone has already used that email!";
}
}
else
{
echo "Username already taken ...";
}
}

else{
echo "Your emails don't match!";
}
}
// user login code
if(isset($_POST["user_login"])&& isset($_POST["password_login"])){
$user_login = preg_replace('#[^A-Za-z0-9]#i','',$_POST['user_login']); //filter everything except num and letters

$password_login = preg_replace('#[^A-Za-z0-9]#i','',$_POST['password_login']);//filter everything except numbers and letters
$password_login_md5 = md5($password_login);
$sql = mysql_query("SELECT id FROM users WHERE username ='$user_login' AND password='$password_login_md5' AND closed='no' LIMIT 1");//query
//check for their existence
$userCount = mysql_num_rows($sql);//count the no. of rows returned
if($userCount == 1)
{
	while($row = mysql_fetch_array($sql)){
		$id = $row["id"];
		
}

$_SESSION["user_login"] = $user_login;

header("location: home.php");
exit();
}
else{
	echo"Username or Password is incorrect!<br>"
	;
}
}
?>

<div style="width:800px; margin: 0px auto 0px auto;">
<table>
<tr>
<td width="60%" valign="top">
<h2>Already a Member? Sign in below!</h2>
<form action="index.php" method="POST">
<input type="text" name="user_login" size="25" onClick="value=''" value="Username"/><br/><br/>
<input type="text" name="password_login" size="25" onClick="value=''" value="Password"/><br/><br/>
<input type="submit" name="login" value="Login">&nbsp;<a style='text-decoration:none; font-size:14px;' href=" forgot.php">Forgot Password???</a>
</form>
</td>
<td width="40%" valign="top">
<h2>Sign Up Below!</h2>
<form action="index.php" method="POST">
<input type="text" name="fname" size="25" onClick="value=''" value="First Name"/><br /><br />
<input type="text" name="lname" size="25" onClick="value=''" value="Last Name"/><br /><br />
<input type="text" name="username" size="25" onClick="value=''" value="Username"/><br /><br />
<input type="email" name="email" size="25" onClick="value=''" value="Email Address"/><br /><br />
<input type="email" name="email2" size="25" onClick="value=''" value="Re-enter Email Address"/><br /><br />

<input type="text" name="password" size="25" onClick="value=''" value="Password"/><br /><br />
<input type="text" name="password2" size="25" onClick="value=''" value="Re-enter Password"/><br /><br />
<input type="submit" name="reg" value="Sign Up!"/>
</form>
</td>
</tr>
</table>
<?php include("./inc/footer.inc.php"); ?>
