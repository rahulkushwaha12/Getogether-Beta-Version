<?php
error_reporting(0);
include ("./inc/connect.inc.php");
session_start();
if(!isset($_SESSION["user_login"])){
	$username = "";
}
else{
	$username = $_SESSION["user_login"];
}
$post = $_POST['post'];
if($post !=""){
	   		date_default_timezone_set('Asia/Calcutta');
        $date_added = date('Y/m/d H:i:s');
//$date_added = date("Y-m-d");
$added_by = $username;
$user_posted_to = "";

$sqlCommand = "INSERT INTO posts VALUES('','$post','$date_added','$added_by','$user_posted_to')";
$query = mysql_query($sqlCommand) or die (mysql_error());

}
else
{
echo "You must enter something in the post field before you can send it...";
}
?>