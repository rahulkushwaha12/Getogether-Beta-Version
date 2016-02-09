
<?php
error_reporting(0);
include("./inc/header.inc.php");
echo '<div style="height:40px; width:100%;"></div>';
if(!isset($_SESSION["user_login"])){
	echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
}
else{
	

if(isset($_GET['topic'])){
$topic = mysql_real_escape_string($_GET['topic']);
$topic = strip_tags($topic);
}
if($topic == 'science-technology' || $topic == 'books-studies' || $topic == 'music-movies' || $topic == 'fashion-style' || $topic == 'friendship-relationships' || $topic == 'writing-literature' || $topic == 'travel-photography' ||     $topic == 'health-wealth' || $topic == 'graduation-colleges' || $topic == 'miscellaneous-talks' ){
	
$post = mysql_real_escape_string(@$_POST['post']);
if($post !=""){
	date_default_timezone_set('Asia/Calcutta');
$date_added = date('Y/m/d H:i:s');
//$date_added = date("Y-m-d");
$added_by = $username;
//$user_posted_to = $username;
if($post == ''){
	echo "Question field is empty!";
}
else{
$sqlCommand = "INSERT INTO questions VALUES('','$topic','$post','$date_added','$added_by','')";
$query = mysql_query($sqlCommand) or die (mysql_error());

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

$insert_notifications = mysql_query("INSERT INTO notifications VALUES('','$topic','asked a question','$date_added','$added_by','$friendUsername','')") or die(mysql_error());

}}

}}


?>
<div class="homeTitleBar">
<div class="homeTopics">
<h2>Topics</h2>
</div>

<div class="newsFeed">
<h2><?php echo $topic ; ?></h2>

</div>
</div>

<div class="homeContent">
<div class="homeLeftSide">
  <ul class="navigation">
<li><a href="topics.php?topic=science-technology"><img src="images/sciandtech.jpg" height="50" width="50"><div class="txt">Science and Technology</div></a></li>
<li><a href="topics.php?topic=books-studies"><img src="images/bookandstu.jpg" height="50" width="50"><div class="txt">Books <br> and Studies</div></a></li>
<li><a href="topics.php?topic=music-movies"><img src="images/musicandmov.jpg" height="50" width="50"><div class="txt">Music<br> and Movies</div></a></li>
<li><a href="topics.php?topic=fashion-style"><img src="images/fashionandsty.jpg" height="50" width="50"><div class="txt">Fashion<br> and Style</div></a></li>
<li><a href="topics.php?topic=friendship-relationships"><img src="images/frndandrelation.jpg" height="50" width="50"><div class="txt">Friendship Vs Relationships</div></a></li>
<li><a href="topics.php?topic=writing-literature"><img src="images/writingandlite.jpg" height="50" width="50"><div class="txt">Writing<br> and Literature</div></a></li>
<li><a href="topics.php?topic=travel-photography"><img src="images/travelandphoto.jpg" height="50" width="50"><div class="txt">Travel<br> and Photography</div></a></li>
<li><a href="topics.php?topic=health-wealth"><img src="images/healandwealth.jpg" height="50" width="50"><div class="txt">Health<br> and Wealth</div></a></li>
<li><a href="topics.php?topic=graduation-colleges"><img src="images/graduandclg.jpg" height="50" width="50"><div class="txt">Graduation<br>and Colleges</div></a></li>
<li><a href="topics.php?topic=miscellaneous-talks"><img src="images/misctalks.jpg" height="50" width="50"><div class="txt">Miscellaneous <br>Talks</div></a></li>  
    Copyright © 2014 | GeTogether   
        </ul>
         
</div>
<div class="homeRightSide">
<div class="homePostForm">
<form action="topics.php?topic=<?php echo $topic; ?>" method = "POST">

<textarea id="post" name="post" rows="3" cols="95" placeholder="Enter your question here ..." ></textarea>
<input type="submit" name="send"  value="Post" style="  border: 1px solid #666; float:right; height:40px; width:60px; border-radius:0px; "/>
</form>
</div>
<?php
$getposts = mysql_query("SELECT * FROM questions WHERE topic = '$topic' ORDER BY id DESC LIMIT 20") or die(mysql_error());
while ($row = mysql_fetch_assoc($getposts)){
$id = $row['id'];
$body = $row['body'];
$date_added = $row['date_added'];
$added_by = $row['added_by'];
//$user_posted_to = $row['user_posted_to'];

$get_user_info = mysql_query("SELECT * FROM users WHERE username='$added_by'");
$get_info = mysql_fetch_assoc($get_user_info);
$profilepic_info = $get_info['profile_pic'];


if($profilepic_info == ""){
$profilepic_info= "img/default_pic.png";
}
else{
	$profilepic_info= "userdata/profile_pics/$profilepic_info";
}


?>
<script language="javascript">
function toggle<?php echo $id; ?>(){
var ele = document.getElementById("toggleComment<?php echo $id;?>");
var text = document.getElementById("displayComment<?php echo $id;?>");
if(ele.style.display == "block"){
	ele.style.display = "none";

}
else{
ele.style.display = "block";
	}

}
</script>
<?php


if(@$_POST['delete_' . $id . '']){
		
$delete_ques_query = "DELETE FROM questions  WHERE id='$id' AND topic = '$topic'"; 
if(mysql_query($delete_ques_query)){
echo "<script>alert('Question Has been Deleted')</script>";
echo "<script>window.open('topics.php?topic=$topic','_self')</script>";
}}



$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$added_by'");
	$full_name = mysql_fetch_assoc($users_query);
	$first_name = $full_name['first_name'];
	$last_name = $full_name['last_name'];


$insert_like = mysql_query("INSERT INTO ques_likes VALUES ('','$topic', '$id', '-1', '$added_by$id')");
$count_query = mysql_query("SELECT * FROM answers WHERE post_id='$id' AND post_removed='0'");
$count_ans = mysql_num_rows($count_query);


echo "

<div class='newsFeedPost'>

<div  style='float: left;'><a href='$added_by'><img src=$profilepic_info height='50' width='45'></a></div>

<div class='posted_by' style='float:right; height:20px; background-color:#dce5ee; width:702px;'><a style='background-color:#dce5ee;' href='$added_by'>$first_name $last_name </a>asked a ques on $date_added ";
if($added_by == $username){
	
echo"
<div class='delete_ques'>
<form method='POST' action='topics.php?topic=$topic' name='$id'>
<input style='background-color:#dce5ee; padding: 0px; margin: 0px; color:#CC99CC; font-size:16px; border: 0px;' type='submit' name='delete_$id' value=\"X\" title='delete ques'>
</form>
</div>";

}
else{
//do nothing	
}
echo"
</div>
<div style='font-size: 14px; font-weight:700; float:right; background-color:#dce5ee; min-height: 30px; width:702px;'>Q. $body?</div>

<div class='newsFeedPostOptions' style='height: 30px; background-color:#0ff;'>
<a href='#' onClick='javascript:toggle$id()'>Show Answers($count_ans)</a>
<iframe src='http://getogether.net46.net/ques_like_but_frame.php?uid=$added_by$id&topic=$topic' style=' border: 0px; height: 28px; width: 120px;'> </iframe>
</div>


<div id='toggleComment$id' style='display: none;'>
<iframe src='./comment_frame.php?id=$id&topic=$topic' frameborder='0' style='max-height: 150px; height:auto; width: 100%; min-height: 400px;'></iframe>
</div>


</div>
<br /><br /><br />
	";

}
}
else{
	echo"
	<center>
	 ERROR 404 !
	<br />
	Before you begin with that sql injection.
	<br />
	your ip address is being noted down.
	<br />
	and we will get back you soon.
	</center>
	";
//echo "<meta http-equiv=\"refresh\" content=\"0; url=home.php\">";	
	
	
}

}

?>

</div>
<!--<div class="newsFeedmorepost">
<center><h2>Show More Questions</h2><center>
<form method="POST" action="home.php" name="$id">
<input style="background-color:#dce5ee; padding: 0px; margin: 0px; color:#CC99CC; font-size:16px; border: 0px;" type="submit" name="delete_$id" value="show more posts" title="delete ques">
</form>
</div>-->
</div>
