<?php include ("./inc/header.inc.php");
error_reporting(0);
?>
<?php
echo '<div style="height:40px; width:100%;"></div>';
?>
<h2>Did you forgot your password or username?</h2><hr /><br />
<h2>Don't Worry we will get back you soon !!!</h2>
<ul>

<?php

if(isset($_POST['senddata'])){
	 $dob = mysql_real_escape_string ($_POST['dob']);

$query = mysql_query("SELECT * FROM users WHERE dob like '%$dob%'");
$rows = mysql_num_rows($query);
if($rows != 0){
	?><h3>VERIFY YOUR IDENTITY:</h3><br>
<?php
while($get = mysql_fetch_assoc($query)){
$id = $get['id'];	
$username = $get['username'];
$firstname = $get['first_name'];
$lastname = $get['last_name'];
$profile_pic = $get['profile_pic'];
if($profile_pic == ""){
$profile_pic = "img/default_pic.png";
}
else
{
$profile_pic = "userdata/profile_pics/".$profile_pic;
}

echo"
<li style='list-style:none;'>
<img src='$profile_pic' height='40' width='40'>
<b style='font-size: 16px;'>$firstname $lastname</b><a style ='text-decoration:none; font-size:16px;' href='check_email.php?checkid=$id'>  confirm</a>
</li>
</ul>
";


?><?php }
echo "<br>
<hr>";
}
else{
echo "No accounts found...please contact administrator!!!";
}}?>

<form action="forgot.php" method="post">
<h3>JUST A SMALL SURVEY FOR YOU:</h3><br />
Your Date of Birth: <input type="text" name="dob" id="dob" size="40">(e.g. 12-jan-1993 or 12-jan as u have given at the time of registration.)<br />
<input type="submit" name="senddata" id="senddata" value="continue">
</form>