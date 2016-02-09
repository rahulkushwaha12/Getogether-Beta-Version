<?php
error_reporting(0);
session_start();
if(!isset($_SESSION["user_login"])){
	$username = "";
}
else{
	$username = $_SESSION["user_login"];
}
?>
<style>
*{
font-size: 12px;
font-family: Arial, Helvetica, Sans-serif;

}
hr {
background-color:#dce5ee;
height: 1px;
border: 0px;
}
</style>


<?php
include("./inc/connect.inc.php");
$getid =mysql_real_escape_string(@$_GET['id']);

$topic = mysql_real_escape_string($_GET['topic']);



?>

<script language="javascript">
function toggle(){
var ele = document.getElementById("toggleComment");
var text = document.getElementById("displayComment");
if(ele.style.display == "block"){
	ele.style.display = "none";

}
else{
ele.style.display = "block";
	}

}
</script>

<?php
$rand_dir_name="";
//profile img upload script
if (isset($_FILES['profilepic'])){
	
if(((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"] ["size"] < 1048576)) //1megabyte
{
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name = substr(str_shuffle($chars), 0, 15);
mkdir("userdatacomment/profile_pics/$rand_dir_name");


}
}

if (isset($_POST['postComment' . $getid . ''])){
	$post_body = @$_POST['post_body'];
	date_default_timezone_set('Asia/Calcutta');
$date_added = date('Y/m/d H:i:s');
//$posted_to="";
//echo "Uploaded and stored in: userdatacomment/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
move_uploaded_file(@$_FILES["profilepic"]["tmp_name"], "userdatacomment/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"]);
$profile_pic_name = @$_FILES["profilepic"]["name"];
if($profile_pic_name=='' && $post_body==''){
	// do nothing
}
else{
if($profile_pic_name==''){
$insertPost = mysql_query("INSERT INTO answers VALUES ('','$topic','$post_body','$username','0','$getid','','$date_added')")or die("error 404...");


// sending notifications to all my friends
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

$insert_notifications = mysql_query("INSERT INTO notifications VALUES('','$topic','answered a question','$date_added','$username','$friendUsername','')") or die(mysql_error());

}}




}
else{
$insertPost = mysql_query("INSERT INTO answers VALUES ('','$topic','$post_body','$username','0','$getid','$rand_dir_name/$profile_pic_name','$date_added')")or die("error 404...");

// sending notifications to all my friends
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

$insert_notifications = mysql_query("INSERT INTO notifications VALUES('','$topic','answered a question','$date_added','$username','$friendUsername','')") or die(mysql_error());

}}

}}
//echo "Answer Posted!<br />";
}
?>

   <a href='javascript:;' onClick="javascript:toggle()"><div style='float: right;  font-size:14px;'>Answer this Question</div></a>
   <div id='toggleComment' style='display: none;'>
<form action="comment_frame.php?id=<?php echo $getid ;?>&topic=<?php echo $topic; ?>" method="POST" name="postComment<?php echo $getid; ?>" enctype="multipart/form-data">
Enter your answer below:<br />
<textarea rols="20" cols="103" name="post_body" style="height: 40px;" placeholder="Enter your answer here ..."></textarea>

<input type="file" name="profilepic" />

<input type="submit" name="postComment<?php echo $getid; ?>" value="Submit Answer">
</div>
   
<?php
$get_comments = mysql_query("SELECT * FROM answers WHERE post_id='$getid' AND post_removed='0' ORDER BY id DESC");
$count = mysql_num_rows($get_comments);
if($count != 0){
while($comment = mysql_fetch_assoc($get_comments)){
	$id = $comment['id'];
$comment_body = $comment['post_body'];
//$posted_to = $comment['posted_to'];
$posted_by = $comment['posted_by'];
$removed = $comment['post_removed'];

$date = $comment['date_added'];
$comment_pic =$comment['post_photo'];

if(@$_POST['delete_' . $id . '']){
		
$delete_ans_query = mysql_query("UPDATE answers SET post_removed='1' WHERE id='$id' AND topic = '$topic'")or die(mysql_error());
//if(mysql_query($delete_ans_query)
echo "ans deleted";
header("Location: comment_frame.php?id=$getid&topic=$topic");
}

$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$posted_by'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name = $full_name['first_name'];
	$last_name = $full_name['last_name'];


echo "<a style='text-decoration:none; font-size: 16px; ' href='$posted_by'>$first_name $last_name</a> answered: on $date";

if($posted_by == $username){
	
echo"
<div>
<form method='POST' action='comment_frame.php?id=$getid&topic=$topic' name='$getid'>
<input style='background-color:#0ff; padding: 0px; margin: 0px; color:#CC99CC; float:right; font-size:16px; border: 0px;' type='submit' name='delete_$id' value=\"X\" title='delete ans'>
</form></div>
";

}
else{
//do nothing	
}

echo"

 <br />Ans:";
if($comment_pic == ''){
//do nothing
}else{
echo "<center><img src='userdatacomment/profile_pics/$comment_pic' height= '100' width='150'/></center>";
}

echo "
<b style='font-size: 14px; font-weight: 100; padding-left:10px;' >".$comment_body."</b><hr />";

}}
else
{
	echo "<center>Be the first person to answer this question!</center>";
}
?>