<?php
error_reporting(0);
 include ("./inc/connect.inc.php"); 
session_start();
$username = $_SESSION["user_login"];
	echo $username;

	$query = mysql_query("UPDATE users SET online = '0' WHERE username='$username'")or die("could not update");

session_start();
session_destroy();
header("location: index.php");
?>