<link rel="stylesheet" type="text/css" href="./css/style.css">
<?php
error_reporting(0);
session_start();
if(!isset($_SESSION["user_login"])){
	$username = "";
}
else{
	$username = $_SESSION["user_login"];
}

include("./inc/connect.inc.php");
$id = "";

if(isset($_GET['topic'])){
$topic = mysql_real_escape_string($_GET['topic']);
$topic = strip_tags($topic);
}

if(isset($_GET['uid'])){
$uid = mysql_real_escape_string($_GET['uid']);
if(ctype_alnum($uid)){

$get_likes = mysql_query("SELECT * FROM ques_likes WHERE uid='$uid'");
//if(mysql_num_rows($get_likes)===1){
$get = mysql_fetch_assoc($get_likes);
$uid = $get['uid'];
$total_likes = $get['total_likes'];
$total_likes = $total_likes+1;
$remove_likes = $total_likes-2;
//}
//else{

//die("Error 404 ...");
//}


if(isset($_POST['likebutton_'])){

$like = mysql_query("UPDATE ques_likes SET total_likes='$total_likes' WHERE uid='$uid'  ");
$user_likes = mysql_query("INSERT INTO ques_user_likes VALUES ('','$topic', '$username', '$uid')");
header("Location: ques_like_but_frame.php?uid=$uid&topic=$topic");
}
if(isset($_POST['unlikebutton_'])){

$like = mysql_query("UPDATE ques_likes SET total_likes='$remove_likes' WHERE uid='$uid' ");
$remove_user = mysql_query("DELETE  FROM ques_user_likes  WHERE uid='$uid' AND username='$username'  ");
header("Location: ques_like_but_frame.php?uid=$uid&topic=$topic");
}}}




// check for previous likes
$check_for_likes = mysql_query("SELECT * FROM ques_user_likes WHERE username='$username' AND uid='$uid' ")or die(mysql_error());
$numrows_likes = mysql_num_rows($check_for_likes);
if($numrows_likes >=1){
	echo '
<form action="ques_like_but_frame.php?uid=' . $uid . '&topic=' . $topic . '" method="POST">
<input type="submit" name="unlikebutton_' . $id . '" value="Unlike">
<div style=" display: inline;">
' .  $total_likes . 'likes
</div>
</form>
';
}
else if($numrows_likes == 0){
echo '
<form action="ques_like_but_frame.php?uid=' . $uid . '&topic=' . $topic . '" method="POST">
<input type="submit" name="likebutton_' . $id . '" value="Like">
<div style="display: inline;">
' .  $total_likes . 'likes
</div>
</form>
';
}
?>