<?php include("./inc/header.inc.php");
error_reporting(0);?>
<?php
echo '<div style="height:40px; width:100%;"></div>';
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
?>


