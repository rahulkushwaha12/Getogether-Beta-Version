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
<h2>All Notifications:</h2><hr />
<ul class="notifications">

<?php
$query = mysql_query("SELECT * FROM notifications WHERE user_to = '$username' AND deleted = '0' ")or die(mysql_error());
$rows = mysql_num_rows($query);
if($rows != 0){
while($get = mysql_fetch_array($query)){
$topic = $get['topic'];
$activity = $get['activity'];
$date_added = $get['date_added'];
$added_by = $get['added_by'];
$notification_id = $get['notification_id'];
$users_query = mysql_query("SELECT first_name, last_name FROM users WHERE username='$added_by'");
	$full_name = mysql_fetch_assoc($users_query);
	$firstname = $full_name['first_name'];
	$lastname = $full_name['last_name'];

?>

<li>
<?php
if(@$_POST['clear_' . $notification_id . '']){
$delete_query = mysql_query("DELETE FROM notifications WHERE notification_id = '$notification_id'") or die (mysql_error());
//header("Location: my_messages.php");
echo "<meta http-equiv=\"refresh\" content=\"0; url=notifications.php\">";

}
?>
<form method="POST" action="notifications.php" name="clear_notifications" >
<b style="font-size:16px; font-weight:200;">
<a href="topics.php?topic=<?php echo $added_by; ?>"><?php echo $firstname." ".$lastname." " ;?></a>
<?php echo $activity." "; ?>in
<a href="topics.php?topic=<?php echo $topic; ?>"><?php echo " ".$topic." "; ?></a> on
<?php echo " ".$date_added;?></b>
<input type="submit" name="clear_<?php echo $notification_id; ?>" value="clear" title="clear this notification" >
</form> 

</li>


<?php }?>
<?php
}
else
echo "No notifications to display!";
?>

</ul>