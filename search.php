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

<h2>Your Search Result is Here:</h2><hr />
<?php

if(isset($_GET['search'])){
	
 $search_id = mysql_real_escape_string ($_GET['search']);

$search_query="select * from users where username like '%$search_id%' OR first_name like '%$search_id%' OR last_name like '%$search_id%' OR email like '%$search_id%'"; 
$run_query=mysql_query($search_query) or die(mysql_error());
while ($search_row=mysql_fetch_array($run_query)){

$username=$search_row['username'];
$first_name=$search_row['first_name'];
$last_name=$search_row['last_name'];
$email=$search_row['email'];
$profile_pic=$search_row['profile_pic']; 
if($profile_pic == ""){
$profile_pic = "img/default_pic.png";
}
else
{
$profile_pic = "userdata/profile_pics/".$profile_pic;
}


?>


<h2><div>
<a style="font-size:14px; text-decoration:none;" href="<?php echo $username; ?>">
<img src="<?php echo $profile_pic; ?>" height="40" width="40">

<?php echo $first_name." ".$last_name?></a>

</a>
<div>
</h2>



<?php }} ?> 
