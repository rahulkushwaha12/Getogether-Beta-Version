<?php
error_reporting(0);
include("./inc/header.inc.php");
if($username){
	echo '<div style="height:40px; width:100%;"></div>';
}
else{
	echo '<div style="height:40px; width:100%;"></div>';
die ("You must be logged in to view this page!");
}
?>
<div  class="message_content_body">
<div class="read_unread_messages">


<?php
//include ("./inc/header.inc.php");
//echo '<div style="height:40px; width:100%;"></div>';

if(isset($_GET['m'])){
$username1 = mysql_real_escape_string($_GET['m']);
if(ctype_alnum($username1)){
//check user exists
$check = mysql_query("SELECT username, first_name, last_name FROM users WHERE username='$username1'");
if(mysql_num_rows($check)===1){
	$get = mysql_fetch_assoc($check);
	
	$firstname = $get['first_name'];
	$lastname = $get['last_name'];
	$username1 = $get['username'];
	//check user isn't sending themselves a private msg
if($username1 != $username){
	if(isset($_POST['submit'])){
		//$msg_title = mysql_real_escape_string(@$_POST['msg_title']);
		$msg_title = "open";
		$msg_body = mysql_real_escape_string(@$_POST['msg_body']);
   		date_default_timezone_set('Asia/Calcutta');
        $date = date('Y/m/d H:i:s');
		//$date = date("Y-m-d");
		$opened = "no";
		$deleted = "no";
		if($msg_title == ""){
echo "Please give your message a title.";
}
		else if($msg_body == ""){
echo "Please write a message.";
}
else{
		$send_msg = mysql_query("INSERT INTO pvt_messages VALUES ('','$username','$username1','$msg_title','$msg_body','$date','$opened', '$deleted')");
echo "Your message has been sent!";
}
}

echo"
<form action='send_msg.php?m=$username1' method='POST'>
<h2>Compose a Message:($firstname $lastname)</h2>

<textarea cols='75' rows='8' name='msg_body' placeholder='enter your message here'></textarea><p />
<input type='submit' name='submit' value='Send Message'>
</form>

";

}
else
{
header("Location: $username");
}
	} 
}
}

?>
</div>
<div class="online_friends">
<h2>Online Friends:</h2>

<?php


 //friend lists
$friendsArray = "";
$countFriends = "";
$friendsArray12 = "";
$addAsFriend = "";
$selectFriendsQuery = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
$friendRow = mysql_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];
if($friendArray!= ""){

$friendArray = explode(",",$friendArray);
$countFriends = count($friendArray);
$friendArray12 = array_slice($friendArray, 0, 12);


$i = 0;
}



?>
<ul class="onlinefriends">
<?php

if($countFriends != 0){
foreach ($friendArray12 as $key => $value){
$i++;
$getFriendQuery = mysql_query("SELECT * FROM users WHERE username = '$value' AND online= 1 LIMIT 1");
$getFriendRow = mysql_fetch_assoc($getFriendQuery);
$friendUsername = $getFriendRow['username'];


if($friendUsername == ''){
	
}
else{
$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$friendUsername'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name1 = $full_name['first_name'];
	$last_name1 = $full_name['last_name'];

echo"<li>";
echo"<a href='send_msg.php?m=$friendUsername'>".$first_name1." ".$last_name1."<img src='img/green_dot.png' height='15' width='15'></a>";

echo"</li>";
}
//$friendProfilePic = $getFriendRow['profile_pic'];

//if($friendProfilePic == ""){
//echo " <a href='$friendUsername'><img src='img/default_pic.png' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='55' width='45' style='padding-left:5px;'></a>";

//}
//else{
	//echo " <a href='$friendUsername'><img src='userdata/profile_pics/$friendProfilePic' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='55' width='45' style='padding-left:5px;'></a>";

//}
}
}

else
echo "you have no friends yet!";
?>
</ul>
</div>
</div>