<?php
error_reporting(0);
include("inc/header.inc.php");
echo '<div style="height:40px; width:100%;"></div>';
?>
<h2>Create Your Like Button</h2><hr />
<form action="create_like_button.php" method="POST">
<input type="text" name="like_button_url" value="Enter the URL of your page..." size="50" onClick="value=''">
<input type="submit" name="create" value="Create" />
</form>
<?php
if(isset($_POST['like_button_url'])){
$like_button_url = strip_tags(@$_POST['like_button_url']);
$username1 = $username;
date_default_timezone_set('Asia/Calcutta');
$date = date('Y/m/d H:i:s');
$uid = rand(36556522658951, 9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999);
$uid = md5($uid);

$like_button_url2 = strstr($like_button_url, 'http://');

	//check whether like button already exists in the database
$b_check = mysql_query("SELECT page_url FROM like_buttons WHERE page_url='$like_button_url'");
//count the number of rows returned
$numrows_check = mysql_num_rows($b_check);
if($numrows_check >=1){
echo "Already exists.";
}
	else{
		if($like_button_url2){
$create_button = mysql_query("INSERT INTO like_buttons VALUES ('', '$username1', '$like_button_url', '$date', '$uid')");
$insert_like = mysql_query("INSERT INTO likes VALUES ('', '$username1', '-1', '$uid')");
echo "

<div style='width: 400px; height: 250px; border: 1px solid #cccccc;'>
&lt;iframe src='http://getogether.net46.net/like_but_frame.php?uid=$uid' style='border: 0px; height: 28px; width: 85px;'&gt;

&lt;/iframe&gt;
</div>
";

}
else{
$like_button_url = "http://".$like_button_url;
$create_button = mysql_query("INSERT INTO like_buttons VALUES ('', '$username1', '$like_button_url', '$date', '$uid')");
$insert_like = mysql_query("INSERT INTO likes VALUES ('', '$username1', '-1', '$uid')");
echo "

<div style='width: 400px; height: 250px; border: 1px solid #cccccc;'>
&lt;iframe src='http://getogether.net46.net/like_but_frame.php?uid=$uid' style='border: 0px; height: 28px; width: 85px;'&gt;

&lt;/iframe&gt;
</div>
";
}
}




}

?>
