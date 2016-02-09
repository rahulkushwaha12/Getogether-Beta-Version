<?php
error_reporting(0);
include("./inc/header.inc.php");
if($username){
	echo '<div style="height:40px; width:100%;"></div>';
}


else{
	echo '<div style="height:40px; width:100%;"></div>';
	if(isset($_GET['u'])){
$username1 = mysql_real_escape_string($_GET['u']);
$check_pic = mysql_query("SELECT profile_pic FROM users WHERE username='$username1'");
$get_pic_row = mysql_fetch_assoc($check_pic);
$get_rows = mysql_num_rows($check_pic);

}
if($get_rows != 0 ){
$profile_pic_db = $get_pic_row['profile_pic'];
if($profile_pic_db == ""){
$profile_pic = "img/default_pic.png";
}
else
{
$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}

$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$username1'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name = $full_name['first_name'];
	$last_name = $full_name['last_name'];

?>
<div style="margin-left:400px; margin-right:400px;"><img src="<?php echo $profile_pic; ?>" height="190" width="187" alt="<?php echo $first_name." ".$last_name; ?>'s Profile'" title="
<?php echo $first_name." ".$last_name; ?>'s Profile"/></div>	<br />
<?php	
	
	
die("&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTo connect with $first_name $last_name you must log in first !");
	}
	else{
	header("Location: index.php");
	}
	
}

?>
<?php
//echo '<div style="height:40px; width:100%;"></div>';
if(isset($_GET['u'])){
$username1 = mysql_real_escape_string($_GET['u']);
if(ctype_alnum($username1)){
//check user exists
$check = mysql_query("SELECT username, first_name FROM users WHERE username='$username1'");
if(mysql_num_rows($check)===1){
	$get = mysql_fetch_assoc($check);
	
	$firstname = $get['first_name'];
	$username1 = $get['username'];
	}
else
{
	echo "User does not exists!";
	header("location: index.php");
	exit();
	}
}
}


?>
<?php
$rand_dir="";
//profile img upload script
if (isset($_FILES['postpic'])){
	
if(((@$_FILES["postpic"]["type"]=="image/jpeg") || (@$_FILES["postpic"]["type"]=="image/png") || (@$_FILES["postpic"]["type"]=="image/gif"))&&(@$_FILES["postpic"] ["size"] < 1048576)) //1megabyte
{
$char = "cdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567";
$rand_dir = substr(str_shuffle($char), 0, 15);
mkdir("userdataposts/profile_pics/$rand_dir");

}
}

if (isset($_POST['send'])){
	
	//$post_body = @$_POST['post_body'];

$post = mysql_real_escape_string(@$_POST['post']);
//if($post !=""){
date_default_timezone_set('Asia/Calcutta');
$date_added = date('Y/m/d H:i:s');
//$date_added = date("Y-m-d");
$added_by = $username;
$user_posted_to = $username1;
//echo "Uploaded and stored in: userdataposts/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
move_uploaded_file(@$_FILES["postpic"]["tmp_name"], "userdataposts/profile_pics/$rand_dir/".@$_FILES["postpic"]["name"]);

$post_pic_name = @$_FILES["postpic"]["name"];

if($post_pic_name==''){

$sqlCommand = "INSERT INTO posts VALUES('','$post','$date_added','$added_by','$user_posted_to','')";
$query = mysql_query($sqlCommand) or die (mysql_error());
}
else{
 $sqlCommand = "INSERT INTO posts VALUES('','$post','$date_added','$added_by','$user_posted_to','$rand_dir/$post_pic_name')";
$query = mysql_query($sqlCommand) or die (mysql_error());
	
}

}
?>
<?php
//check whether the user has uploaded a profile pic or not
$check_pic = mysql_query("SELECT profile_pic FROM users WHERE username='$username1'");
$get_pic_row = mysql_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];
if($profile_pic_db == ""){
$profile_pic = "img/default_pic.png";
}
else
{
$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}


?>
<?php
$errorMsg = "";
if(isset($_POST['addfriend'])){
$friend_request = $_POST['addfriend'];
$user_to = $username;
$user_from = $username1;
if($user_to == $username1){
$errorMsg = "You can't send a friend request to yourself!<br />";
}

else{
$create_request = mysql_query("INSERT INTO friend_requests VALUES ('', '$user_to', '$user_from')");


$errorMsg = "Your friend request has been sent!";
}
}

?>

<!--<h2>Profile page for: <?php echo "$username"; ?></h2>
<h2>First name: <?php echo "$firstname"; ?></h2>-->
<div id="leftsection">
<div class="postForm">
<form action="<?php echo $username1; ?>" method = "POST" enctype="multipart/form-data">

<textarea id="post" name="post" rows="3" cols="90" placeholder="Update your status and write on your friend's wall here... "></textarea>

<input type="submit" name="send"  value="Post" style="width:60px; height:40px; margin-right:10px; float:right; border: 1px solid #666; border-radius:0px"/>
<input type="file" name="postpic" />
</form>

</div>
<div class="profilePosts">
<?php


$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$username1'ORDER BY id DESC LIMIT 20") or die(mysql_error());
while ($row = mysql_fetch_assoc($getposts)){
$id = $row['id'];
$body = $row['body'];
$date_added = $row['date_added'];
$added_by = $row['added_by'];
$user_posted_to = $row['user_posted_to'];
$comment_pic =$row['post_pic'];

$get_user_info = mysql_query("SELECT * FROM users WHERE username='$added_by'");
$get_info = mysql_fetch_assoc($get_user_info);
$profilepic_info = $get_info['profile_pic'];

if($comment_pic == ''&& $body== ''){
//do nothing
}
else{
	
	if(@$_POST['delete_' . $id . '']){
		
$delete_msg_query = "DELETE FROM posts  WHERE id='$id'"; 
if(mysql_query($delete_msg_query)){
echo "<script>alert('Post Has been Deleted')</script>";
echo "<script>window.open('$username','_self')</script>";
}
//echo " post deleted";
//header("Location: $username");
}
	
if($profilepic_info == ""){
	
echo "
<div style='float:left;'>

	<a href='$added_by'><img src='img/default_pic.png' height='45' width='40'></a>
	</div>
	";
}
else {
	
echo "
	<div style='float:left;'>
<a href='$added_by'><img src='userdata/profile_pics/$profilepic_info' height='45' width='40'></a>
</div>
";
}

$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$added_by'");
	$full_name = mysql_fetch_assoc($users_query);
	$firstname = $full_name['first_name'];
	$lastname = $full_name['last_name'];
$insert_like = mysql_query("INSERT INTO likes VALUES ('', '$id', '-1', '$added_by$id')");

echo "
<div class='posted_by' style='float:right; height: 45px; background-color:#dce5ee; width:510px;'><a style='background-color:#dce5ee;' href='$added_by'>$firstname $lastname </a> on $date_added  


";
if($username == $username1){
	
echo"
<div class='delete_post'>
<form method='POST' action='$username' name='$id'>
<input style='background-color:#dce5ee; padding: 0px; margin: 0px; color:#CC99CC; border: 0px;' type='submit' name='delete_$id' value=\"X\" title='delete post'>
</form>
</div>
";
}
else{
//do nothing	
}


echo"
</div>
";
echo "
<div style='font-size: 16px; padding-left:5px; padding-right:5px; color:#000000; font-weight:400; background-color:#dce5ee; width:550px;'>
$body</div>";

}

if($comment_pic == ''){
//do nothing
}
else{
echo "<center ><img src='userdataposts/profile_pics/$comment_pic' height='190' width='230'/></center>";


}
if($comment_pic == ''&& $body== ''){
//do nothing
}
else{
echo "
<center><iframe src='http://getogether.net46.net/like_but_frame.php?uid=$added_by$id' style=' border: 0px; height: 28px; width: 120px;'> </iframe></center>

<br/>
<br />";}}





?>

</div>
<?php

$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$username1'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name = $full_name['first_name'];
	$last_name = $full_name['last_name'];


?>
<div class="profileLeftSideContent" style="padding-top:0px; margin-top:0px;">
&nbsp&nbsp&nbsp&nbsp
<img src="<?php echo $profile_pic; ?>" height="190" width="187" alt="<?php echo $first_name." ".$last_name; ?>'s Profile'" title="<?php echo $first_name." ".$last_name; ?>'s Profile"/>
<!--<?php
echo $errorMsg ;

?>-->

<a href="<?php echo $username1; ?>" style="text-decoration:none; color:#000000;"><div  style="font-family:'Times New Roman', Times, serif; font-weight:500; font-size:20px; text-align:center;"><?php echo $first_name." ".$last_name; ?></div></a>


<form action="<?php echo $username1; ?>" method="POST">
<?php echo $errorMsg; ?>
 <?php
 if (isset($_POST['sendmsg'])){
//header("Location: send_msg.php?m=$username1");
echo "<meta http-equiv=\"refresh\" content=\"0; url=send_msg.php?m=$username1\">";
}
 
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
$friendArray12 = array_slice($friendArray, 0, 12);


$i = 0;
if(in_array($username, $friendArray)){
$addAsFriend = '<input type="submit" name="removefriend"  value="Remove Friend">';

}
else{
$addAsFriend = '<input type="submit" name="addfriend"  value="Add as Friend">';

}
if($username == $username1){
		//do nothing
		}
	else{
echo "&nbsp&nbsp&nbsp".$addAsFriend;
}}


else{
$queryrequest= mysql_query("SELECT * FROM friend_requests WHERE user_from='$username' AND user_to ='$username1'");	
$countrequests = mysql_num_rows($queryrequest);
if($countrequests != 0){
$addAsFriend = '<input type="submit" name="addfriend"  value="Request Sent">';
echo "&nbsp&nbsp&nbsp".$addAsFriend;
	
}
else{
	
$addAsFriend = '<input type="submit" name="addfriend"  value="Add as Friend">';
if($username == $username1){
	//do nothing
}
else{
echo "&nbsp&nbsp&nbsp".$addAsFriend;
}}
}
//$username =logged in user
//$username1 = user who owns profile
if(@$_POST['removefriend']){
// friend array for logged in user
$add_friend_check = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
$get_friend_row = mysql_fetch_assoc($add_friend_check);
$friend_array = $get_friend_row['friend_array'];
$friend_array_explode = explode(",",$friend_array);
$friend_array_count = count($friend_array_explode);


// friend array for user who owns profile
$add_friend_check_username = mysql_query("SELECT friend_array FROM users WHERE username='$username1'");
$get_friend_row_username = mysql_fetch_assoc($add_friend_check_username);
$friend_array_username = $get_friend_row_username['friend_array'];
$friend_array_explode_username = explode(",",$friend_array_username);
$friend_array_count_username = count($friend_array_explode_username);

$usernameComma = ",".$username1;
$usernameComma2 = $username1.",";

$userComma = ",".$username;
$userComma2 = $username.",";

if(strstr($friend_array,$usernameComma)){
$friend1 = str_replace("$usernameComma","",$friend_array);
}
else
if(strstr($friend_array,$usernameComma2)){
$friend1 = str_replace("$usernameComma2","",$friend_array);
}
else
if(strstr($friend_array,$username1)){
$friend1 = str_replace("$username1","",$friend_array);
}
//remove logged in user from other persons array
if(strstr($friend_array,$userComma)){
$friend2 = str_replace("$userComma","",$friend_array);
}
else
if(strstr($friend_array,$userComma2)){
$friend2 = str_replace("$userComma2","",$friend_array);
}
else
if(strstr($friend_array,$username)){
$friend2 = str_replace("$username","",$friend_array);
}
$friend2 = "";
$removeFriendQuery = mysql_query("UPDATE users SET friend_array='$friend1' WHERE username='$username'");
$removeFriendQuery_username = mysql_query("UPDATE users SET friend_array='$friend2' WHERE username='$username1'");
echo "Friend Removed ...";
//header("Location: $username1");
echo "<meta http-equiv=\"refresh\" content=\"0; url=$username1\">";
}

//create like button if it doesn't already exists
$check_like_button = mysql_query("SELECT * FROM like_buttons WHERE uid='$username1'");
$check_like_numrows = mysql_num_rows($check_like_button);
if($check_like_numrows >=1){
// do nothing
}
else{
date_default_timezone_set('Asia/Calcutta');
$date = date('Y/m/d H:i:s');
$create_button = mysql_query("INSERT INTO like_buttons VALUES ('', '$username1', 'http://getogether.net46.net/$username1', '$date', '$username1')");
$insert_like = mysql_query("INSERT INTO likes VALUES ('', '$username1', '-1', '$username1')");
}
?>
<?php 
if($username == $username1){
	//do nothing
}
else{
echo "
<input type='submit' name='sendmsg' value='Send Message' />";
}
?>
</form>


&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<iframe src='http://getogether.net46.net/like_but_frame.php?uid=<?php echo $username1 ;?> ' style='border: 0px; height: 28px; width: 120px;'> </iframe>
<style type="text/css">
h3{
	color:#669966;
	font-family:"Times New Roman", Times, serif;
	font-size:14px;
display:inline;	
}

</style>
<div class="textHeader">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="background-color:#f3f6f9; font-size:16px;">Profile:</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="account_settings.php" style="color:#0066FF;">edit</a></div>
<?php
$quer = mysql_query("SELECT * FROM users WHERE username= '$username1'");
$get_in = mysql_fetch_assoc($quer);
$work = $get_in['work'];
$clg = $get_in['clg'];
$school = $get_in['school'];
$currentcity = $get_in['currentcity'];
$hometown = $get_in['hometown'];
$dob = $get_in['dob'];
$bio = $get_in['bio'];
$relation = $get_in['relation'];
$mob = $get_in['mob'];
$link = $get_in['link'];
?>

<div class="textHeader"> Education/Work:</div>
	<h3>Works at:</h3>&nbsp; <?php echo $work; ?><br>
    <h3>Studies at:</h3>&nbsp;<?php echo $clg; ?><br>
    <h3>Schooling:</h3>&nbsp; <?php echo $school; ?><br><br>
    <div class="textHeader">Places Lived:</div>
    <h3>Current City:</h3>&nbsp;<?php echo $currentcity; ?><br>
    <h3>From:</h3>&nbsp;<?php echo $hometown; ?><br><br>
    <div class="textHeader"> Date of Birth:</div>
    <center><?php echo $dob; ?></center><br>
    <div class="textHeader"> About Me:</div>
    <center><?php echo $bio; ?></center><br>
    <div class="textHeader">Relationship Status:</div>
    <center><?php echo $relation; ?></center><br>
<div class="textHeader"> Contact Info:</div>
     <h3>Mobile No.:</h3>&nbsp; <?php echo $mob; ?><br>
    <h3>Links:</h3>&nbsp;<?php echo $link; ?><br>

</div>
</div>



<div class="profileRightSideContent">

<!--<img src="#" height="55" width="40"/>&nbsp;&nbsp;-->
<?php
	$quesquery = mysql_query("SELECT * FROM questions WHERE added_by = '$username1'");
	$count_ques = mysql_num_rows($quesquery);
	$ansquery = mysql_query("SELECT * FROM answers WHERE posted_by = '$username1'");
	$count_ans = mysql_num_rows($ansquery);
?>
<div class='textHeader'>Questioned(<?php echo $count_ques ;?>) Answered(<?php echo $count_ans ;?>)</div>	
<br />
<?php
if($username != $username1){
	
	//do nothing
}
else{
	
	$requestquery = mysql_query("SELECT * FROM friend_requests WHERE user_to = '$username'");
	$count_requests = mysql_num_rows($requestquery);
	
	
	
echo"<div class='textHeader'><a href='my_friends.php?f=$username'>Friend Requests($count_requests)</a></div>";	
	

//daily profile visitor
$uname = $username;
$vieweepage = $username1; //gets the name of the user whose profile is to be viewed
$check_query = mysql_query("SELECT * FROM daily_views WHERE viewer_name = '$uname' AND viewee_name = '$vieweepage'");
$get_views = mysql_num_rows($check_query);

if($vieweepage==$uname)
{
	//do nothing
}
else{
if($get_views != 0){
// do nothing
}
else{
//$update = mysql_query("UPDATE users_views SET user_counter='$newcounter' WHERE user_name='$vieweepage'");
$insert = mysql_query("INSERT into daily_views (viewer_name, viewee_name) VALUES ('$uname', '$vieweepage')");
}}


$run_query = mysql_query("SELECT * FROM daily_views WHERE viewee_name = '$username1' ORDER BY 1 DESC");
$countviewer = mysql_num_rows($run_query);

if($countviewer == 0){
	?><br/>
<div class="textHeader">Daily Profile Visitors(<?php echo $countviewer; ?>)</div>
<?php
echo "No one has viewed your profile today!";
}
else{

	?>
	
<br/>
<div class="textHeader" >Daily Profile Visitors(<?php echo $countviewer; ?>)</div>
<?php	
	
while($get_user = mysql_fetch_array($run_query)){
	
$viewer = $get_user['viewer_name'];

$getviewQuery = mysql_query("SELECT * FROM users WHERE username = '$viewer'");
$getviewRow = mysql_fetch_assoc($getviewQuery);

$viewerProfilePic = $getviewRow['profile_pic'];

$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$viewer'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name1 = $full_name['first_name'];
	$last_name1 = $full_name['last_name'];


?>
<?php
if($viewerProfilePic == ""){
echo "<a href='$viewer'><img src='img/default_pic.png' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='55' width='40' style='padding-right:6px;'></a>";

}
else{
	echo "<a href='$viewer'><img src='userdata/profile_pics/$viewerProfilePic' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='55' width='40' style='padding-right:6px;'></a>";
}
?>

<?php }}} ?>




<div class="textHeader"><?php 
if($username == $username1){
	echo" <a href='my_friends.php?f=$username1'>Total Friends($countFriends)</a>";

}
else{
 echo $first_name." ".$last_name."'s <a href='my_friends.php?f=$username1'>Friends($countFriends)</a>";
 }?>
</div>

<!--<div class="profileLeftSideContent">-->
<?php

if($countFriends != 0){
foreach ($friendArray12 as $key => $value){
$i++;
$getFriendQuery = mysql_query("SELECT * FROM users WHERE username = '$value'  LIMIT 1");
$getFriendRow = mysql_fetch_assoc($getFriendQuery);
$friendUsername = $getFriendRow['username'];


$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$friendUsername'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name1 = $full_name['first_name'];
	$last_name1 = $full_name['last_name'];


$friendProfilePic = $getFriendRow['profile_pic'];

if($friendProfilePic == ""){
echo " <a href='$friendUsername'><img src='img/default_pic.png' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='55' width='45' style='padding-left:5px;'></a>";

}
else{
	echo " <a href='$friendUsername'><img src='userdata/profile_pics/$friendProfilePic' alt=\"$first_name1 $last_name1's Profile\" title=\"$first_name1 $last_name1's Profile\" height='55' width='45' style='padding-left:5px;'></a>";

}
}
}
else
echo $first_name." ".$last_name." has no friends yet.";
//people you may know
?>
<div class="textHeader">People you may know</div>

<?php
if($countFriends == 0){
$otherfriendsquery	= mysql_query("SELECT * FROM users order by rand() LIMIT 0,12");
while($get_friend = mysql_fetch_array($otherfriendsquery)){
	$otherusername = $get_friend['username'];
	$firstnameother = $get_friend['first_name'];
	$lastnameother = $get_friend['last_name'];
	 $otherProfilePic = $get_friend['profile_pic'];
	?>
    <?php


if($otherProfilePic == ""){
echo " <a href='$otherusername'><img src='img/default_pic.png' alt=\"$firstnameother $lastnameother's Profile\" title=\"$firstnameother $lastnameother's Profile\" height='55' width='45' style='padding-left:5px;'></a>";

}
else{
	echo " <a href='$otherusername'><img src='userdata/profile_pics/$otherProfilePic' alt=\"$firstnameother $lastnameother's Profile\" title=\"$firstnameother $lastnameother's Profile\" height='55' width='45' style='padding-left:5px;'></a>";

}   
  ?>  
<?php }?>
<?php	
}
else{
	
foreach ($friendArray12 as $key => $value){
$i++;
$getFriendQuery = mysql_query("SELECT * FROM users WHERE username = '$value'  LIMIT 1");
$getFriendRow = mysql_fetch_assoc($getFriendQuery);
$friendUsername = $getFriendRow['username'];

//people you may know for the current user
//pending work





}
}
?>
Copyright © 2014 | GeTogether
</div>







