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


<?php
//include("./inc/header.inc.php");
//echo '<div style="height:40px; width:100%;"></div>';
//grab the messages for the logged in user
?>
<div  class="message_content_body">
<div class="read_unread_messages">

 <h2>My Unread Messages:</h2><p />
<?php
$grab_messages = mysql_query("SELECT * FROM pvt_messages WHERE user_to='$username' && opened='no' && deleted='no'");
$numrows=mysql_numrows($grab_messages);
if($numrows != 0){
while($get_msg = mysql_fetch_assoc($grab_messages)){
$id = $get_msg['id'];
$user_from = $get_msg['user_from'];
$user_to = $get_msg['user_to'];
$msg_title = $get_msg['msg_title'];
$msg_body = $get_msg['msg_body'];
date_default_timezone_set('Asia/Calcutta');

$date = $get_msg['date'];
$opened = $get_msg['opened'];
$deleted = $get_msg['deleted'];
?>
<script language="javascript">
function toggle<?php echo $id; ?>(){
var ele = document.getElementById("toggleText<?php echo $id;?>");
var text = document.getElementById("displayText<?php echo $id;?>");
if(ele.style.display == "block"){
	ele.style.display = "none";

}
else{
ele.style.display = "block";
	}

}
</script>
<?php
$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$user_from'");
	$full_name = mysql_fetch_assoc($users_query);
	$firstname = $full_name['first_name'];
	$lastname = $full_name['last_name'];
?>
<?php

if(strlen($msg_title) > 150){

$msg_title = substr($msg_title, 0, 50)." ...";

 }
else
$msg_title = $msg_title;

if(strlen($msg_body) > 150){

$msg_body = substr($msg_body, 0, 50)." ...";

 }
else
$msg_body = $msg_body;

if(@$_POST['setopened_' . $id . '']){
//update the private messages table

$setopened_query = mysql_query("UPDATE pvt_messages SET opened='yes' WHERE id='$id'");

//header("Location: my_messages.php");
echo "<meta http-equiv=\"refresh\" content=\"0; url=my_messages.php\">";

}

if(@$_POST['reply_' . $id . '']){
//header("Location: msg_reply.php?u=$user_from");
echo "<meta http-equiv=\"refresh\" content=\"0; url=send_msg.php?m=$user_from\">";
}
echo "
<form method='POST' action='my_messages.php' name='$msg_title'>
<b><a href='$user_from'>$firstname $lastname:</a></b> 
<input type='button' name='openmsg' value='$msg_title' onClick='javascript:toggle$id()'>
<input type='submit' name='reply_$id' value=\"Reply\">
<input type='submit' name='setopened_$id' value=\"I've read this\">
</form> 

<div id='toggleText$id' style='display: none;'>
<br />$msg_body
</div>
<hr /><br />

";

}
}

else{
echo "You haven't read any messages yet.";	
}

?>
 <h2>My Read Messages:</h2><p />
<?php
$grab_messages = mysql_query("SELECT * FROM pvt_messages WHERE user_to='$username' && opened='yes' && deleted='no'");
$numrows_read = mysql_numrows($grab_messages);
if($numrows_read != 0){
while($get_msg = mysql_fetch_assoc($grab_messages)){
$id = $get_msg['id'];
$user_from = $get_msg['user_from'];
$user_to = $get_msg['user_to'];
$msg_title = $get_msg['msg_title'];
$msg_body = $get_msg['msg_body'];
date_default_timezone_set('Asia/Calcutta');

$date = $get_msg['date'];
$opened = $get_msg['opened'];
$deleted = $get_msg['deleted'];
?>

<script language="javascript">
function toggle<?php echo $id; ?>(){
var ele = document.getElementById("toggleText<?php echo $id;?>");
var text = document.getElementById("displayText<?php echo $id;?>");
if(ele.style.display == "block"){
	ele.style.display = "none";

}
else{
ele.style.display = "block";
	}

}
</script>
<?php
$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$user_from'");
	$full_name = mysql_fetch_assoc($users_query);
	$firstname = $full_name['first_name'];
	$lastname = $full_name['last_name'];
    ?>
<?php

if(strlen($msg_body) > 150){

$msg_body = substr($msg_body, 0, 150)." ...";

 }
else
$msg_body = $msg_body;
if(@$_POST['delete_' . $id . '']){
$delete_msg_query = mysql_query("UPDATE pvt_messages SET deleted='yes' WHERE id='$id'");
//header("Location: my_messages.php");
echo "<meta http-equiv=\"refresh\" content=\"0; url=my_messages.php\">";

}

if(@$_POST['reply_' . $id . '']){
//header("Location: msg_reply.php?u=$user_from");
echo "<meta http-equiv=\"refresh\" content=\"0; url=send_msg.php?m=$user_from\">";
}
echo "<form method='POST' action='my_messages.php' name='$msg_title'>
<b><a href='$user_from'>$firstname $lastname:</a></b> 
<input type='button' name='openmsg' value='$msg_title' onClick='javascript:toggle$id()'>
<input type='submit' name='reply_$id' value=\"Reply\">
<input type='submit' name='delete_$id' value=\"X\" title='delete message'>
</form> 

<div id='toggleText$id' style='display: none;'>
<br />$msg_body
</div>
<hr /><br />
";	
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
<div>