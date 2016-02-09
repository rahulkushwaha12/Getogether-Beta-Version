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

if(isset($_GET['f'])){
$username1 = mysql_real_escape_string($_GET['f']);
//echo $username1;
}
$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$username1'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name = $full_name['first_name'];
	$last_name = $full_name['last_name'];

?>
<?php if($username == $username1){?>
<div style="float:left; width: 450px;">
<h2>Friend Requests:</h2>
<?php

//find friend requests
$friendRequests = mysql_query("SELECT *	FROM friend_requests WHERE user_to = '$username'");
$numrows = mysql_num_rows($friendRequests);
if($numrows == 0){
echo "You have no friend Requests at this time.";
$user_from="";
}
else
{
while ($get_row = mysql_fetch_assoc($friendRequests)){
$id = $get_row['id'];
$user_to = $get_row['user_to'];
$user_from = $get_row['user_from'];

echo ''.$user_from. ' wants to be your friends.'.'<br />';

?>
<?php
if(isset($_POST['acceptrequest'.$user_from])){
// get friend array for logged in user
$get_friend_check = mysql_query("SELECT friend_array FROM users WHERE username = '$username'");
$get_friend_row = mysql_fetch_assoc($get_friend_check);
$friend_array = $get_friend_row['friend_array'];
$friendArray_explode = explode(",",$friend_array);
$friendArray_count = count($friendArray_explode);


//get friend array for person who sent request
$get_friend_check_friend = mysql_query("SELECT friend_array FROM users WHERE username = '$user_from'");
$get_friend_row_friend = mysql_fetch_assoc($get_friend_check_friend );
$friend_array_friend = $get_friend_row_friend['friend_array'];
$friendArray_explode_friend = explode(",",$friend_array);
$friendArray_count_friend = count($friendArray_explode_friend);


if($friend_array == ""){
$friendArray_count = count(NULL);
}
if($friend_array_friend == ""){
$friendArray_count_friend = count(NULL);
}
if($friendArray_count == NULL){
$add_friend_query = mysql_query("UPDATE users SET friend_array = CONCAT(friend_array,'$user_from') WHERE username='$username'");
}

if($friendArray_count_friend == NULL){
$add_friend_query = mysql_query("UPDATE users SET friend_array = CONCAT(friend_array,'$user_to') WHERE username='$user_from'");
}
if($friendArray_count >=1){
$add_friend_query = mysql_query("UPDATE users SET friend_array = CONCAT(friend_array,',$user_from') WHERE username='$username'");
}

if($friendArray_count_friend >=1){
$add_friend_query = mysql_query("UPDATE users SET friend_array = CONCAT(friend_array,',$user_to') WHERE username='$user_from'");
}

$delete_request = mysql_query("DELETE FROM friend_requests WHERE user_to='$user_to'&&user_from='$user_from'");

echo "You are now friends!";
header("Location: friend_requests.php");

}

if(isset($_POST['ignorerequest'.$user_from])){
$ignore_request = mysql_query("DELETE FROM friend_requests WHERE user_to='$user_to'&&user_from='$user_from'");
echo "Request ignored!";
header("Location: friend_requests.php");

}

?>


<form action="friend_requests.php" method="POST">
<input type="submit" name="acceptrequest<?php echo $user_from;?>" value="Accept Request"/>
<input type="submit" name="ignorerequest<?php echo $user_from;?>" value="Ignore Request"/>
</form>
<?php


}}
}
else{
//do nothing
}
?>
</div>
<div style="float:right; width: 450px;">
<h2>All Friends:</h2>
<?php
 //friend lists
$friendsArray = "";
$countFriends = "";
$friendsArray12 = "";
$addAsFriend = "";
$selectFriendsQuery = mysql_query("SELECT friend_array FROM users WHERE username='$username1'");
$friendRow = mysql_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];
if($friendArray!= ""){

$friendArray = explode(",",$friendArray);
$countFriends = count($friendArray);
$friendArray12 = array_slice($friendArray, 0, 1000);
$i = 0;


}
if($countFriends != 0){
foreach ($friendArray12 as $key => $value){
$i++;
$getFriendQuery = mysql_query("SELECT * FROM users WHERE username = '$value'  LIMIT 1");
$getFriendRow = mysql_fetch_assoc($getFriendQuery);
$online = $getFriendRow['online'];
$friendUsername = $getFriendRow['username'];

$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$friendUsername'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name1 = $full_name['first_name'];
	$last_name1 = $full_name['last_name'];

$friendProfilePic = $getFriendRow['profile_pic'];
if($online == 0){
if($friendProfilePic == ""){
echo " 
<div class='all_friends_wrapper'>
<div style='float:left;'>
<a href='$friendUsername'><img src='img/default_pic.png' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='40' width='40' style='padding-left:5px;'></a> </div>
<div class='all_friends'><a href='$friendUsername'>$first_name1 $last_name1 </a>
</div> 
</div>
"; 

}
else{
	echo "
	<div class='all_friends_wrapper'>
	<div style='float:left;'>
	 <a href='$friendUsername'><img src='userdata/profile_pics/$friendProfilePic' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='40' width='40' style='padding-left:5px;'></a> </div>
<div class='all_friends'><a href='$friendUsername'>$first_name1 $last_name1 </a><div>
</div>
";

}}
else{
if($friendProfilePic == ""){
echo " 
<div class='all_friends_wrapper'>
<div style='float:left;'>
<a href='$friendUsername'><img src='img/default_pic.png' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='40' width='40' style='padding-left:5px;'></a> </div>
<div class='all_friends' ><a href='$friendUsername'>$first_name1 $last_name1<img style=' background-color:#0ff;' src='img/green_dot.png' height='15' width='15'> </a>
</div> 
</div>
"; 

}
else{
	echo "
	<div class='all_friends_wrapper'>
	<div style='float:left;'>
	 <a href='$friendUsername'><img src='userdata/profile_pics/$friendProfilePic' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='40' width='40' style='padding-left:5px;'></a> </div>
<div class='all_friends'><a href='$friendUsername'>$first_name1 $last_name1<img style=' background-color:#0ff;' src='img/green_dot.png' height='15' width='15'> </a><div> 
</div>
";

}echo" <br />";
}

}
}
else
echo $first_name." ".$last_name." has no friends yet.";
//people you may know
?>

</div>
