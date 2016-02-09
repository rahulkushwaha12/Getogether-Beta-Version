<?php include ("./inc/connect.inc.php"); 
session_start();
if(!isset($_SESSION["user_login"])){
	$username = "";
}
else{
	$username = $_SESSION["user_login"];
	$online_query = mysql_query("UPDATE users SET online= '1' WHERE username='$username'") or die(mysql_error);
	//$online_query = mysql_query("INSERT INTO users (online) VALUES (0)");	
}

$get_unread_query = mysql_query("SELECT opened FROM pvt_messages WHERE user_to='$username' && opened='no'");
$get_unread = mysql_fetch_assoc($get_unread_query);
$unread_numrows = mysql_num_rows($get_unread_query);
$unread_numrows = "(".$unread_numrows.")";

$get_unclear_query = mysql_query("SELECT * FROM notifications WHERE user_to='$username'");
$get_unclear = mysql_fetch_assoc($get_unclear_query);
$unclear_numrows = mysql_num_rows($get_unclear_query);
$unclear_numrows = "(".$unclear_numrows.")";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" href="img/123.png" media="all"/>
<title>Welcome to GeTogether</title>
<meta name="description" content="An online platform to discuss your questions related to day to day life, answer questions, share your profile, make friends and many more.">
<meta name="keywords" content="getogether, mnnit, rahul, rahul kushwaha, social network, facebook, questions and answers forum">


<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script src="jsmain/main.js" type="text/javascript"></script>
<!--#######################################slider############################################-->
 <link href="themes/8/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="themes/8/js-image-slider.js" type="text/javascript"></script>
    <link href="themes/8/tooltip.css" rel="stylesheet" type="text/css" />
    <script src="themes/8/tooltip.js" type="text/javascript"></script>
   
    <script type="text/javascript">
        imageSlider.thumbnailPreview(function (thumbIndex) { return "<img src='images/thumb" + (thumbIndex + 1) + ".jpg' style='width:70px;height:44px;' />"; });
    </script>
<!--####################slider###################################-->
</head>

<body>
<!--<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
-->

<div class="headerMenu">
<div id="wrapper">
<div class="logo"  >
<a style="text-decoration:none; background:none; font-size:26px; color:#FFFFFF;" href="home.php">GeTogether</a>
<!--<img  style="margin-top:-3px;" src="./img/try.jpg" alt="img not available"/>-->
</div>
<div class="search_box">
<form action="search.php" method="GET" id="search">
<input type="text" name="search" size="60" onClick="value=''" value="Search for people here ..."/>
</form>
</div>
<?php
if(!$username){
	
	echo'<div id="menu">
<a href="index.php">Home</a>
<a href="about.php">About</a>
<a href="contactus.php">Contact us</a>
<a href="team.php">Our Team</a>
</div>';
}
else{

echo'<div id="menu">
<a href="home.php">Home</a>
<a href="'.$username.'">Profile</a>
<a href="my_messages.php">Messages' . $unread_numrows . '</a>
<a href="notifications.php">Notifications' . $unclear_numrows . '</a>
<a href="account_settings.php">Settings</a>
<a href="logout.php">Logout</a>
</div>';
}
?>
</div>
</div>
<div id="wrapper1" style="background-color:0ff;">