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
 $senddata = @$_POST['senddata'];
//password variables
$old_password = strip_tags(@$_POST['oldpassword']);
$new_password = strip_tags(@$_POST['newpassword']);
$repeat_password = strip_tags(@$_POST['newpassword2']);

if($senddata)
{
	if($old_password == "" && $new_password == "" && $repeat_password == ""){
	echo "please enter some data!";
	}
	else{
//if the form has been submitted...
$password_query = mysql_query("SELECT * FROM users WHERE username='$username'");
while($row = mysql_fetch_assoc($password_query)){
$db_password = $row['password'];
//md5 the old password before ve check if it matches
$old_password_md5 = md5($old_password);
//check whether old password equals $db_password
if($old_password_md5 == $db_password){
//continue changing the users password...
//check whether the 2 passwords match
if($new_password == $repeat_password){
	if(strlen($new_password)<=4){
		echo "Sorry! your password must be more than 4 characters long!";
		}
	else{
//md5 the new password before ve add it to database
$new_password_md5 = md5($new_password);
//Great! update the users passwords!
$password_update_query = mysql_query("UPDATE users SET password = '$new_password_md5' WHERE username='$username'");
echo "Success! Your password has been updated!";
}}
else
{
echo "Your two new passwords don't match!";
}
}
else{
echo "The old password is incorrect!";
}
}
}}
else
{
echo "";
}
$updateinfo = @$_POST['updateinfo'];
//first name, last name, and about the user query
$get_info = mysql_query("SELECT first_name, last_name, bio FROM users WHERE username='$username'");
$get_row = mysql_fetch_assoc($get_info);
$db_first_name = $get_row['first_name'];
$db_last_name = $get_row['last_name'];
$db_bio = $get_row['bio'];
//Submit what the user types into the databases
if($updateinfo){
$firstname = strip_tags(@$_POST['fname']);
$lastname =strip_tags( @$_POST['lname']);
$bio = strip_tags(@$_POST['bio']);

if(strlen($firstname)<3){
echo "Your first name must be 3 or more characters long.";
}
else
if(strlen($lastname)<5){
echo "Your last name must be 5 or more characters long.";
}
else{
	$info_update_query = mysql_query("UPDATE users SET first_name='$firstname', last_name='$lastname', bio='$bio' WHERE username='$username'");
	//submitting the form to the database.
echo "Success! your profle has been updated successfully!";	
header ("Location: $username");
}}
else{
//do nothing
}
//check whether the user has uploaded a profile pic or not
$check_pic = mysql_query("SELECT profile_pic FROM users WHERE username='$username'");
$get_pic_row = mysql_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];
if($profile_pic_db == ""){
$profile_pic = "img/default_pic.png";
}
else
{
$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}
//profile img upload script
if (isset($_FILES['profilepic'])){
if(((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"] ["size"] < 1048576)) //1megabyte
{
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name = substr(str_shuffle($chars), 0, 15);
mkdir("userdata/profile_pics/$rand_dir_name");
if (file_exists("userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"]))
{
echo @$_FILES["profilepic"] ["name"]." Aready exists";

}
else{
move_uploaded_file(@$_FILES["profilepic"]["tmp_name"], "userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"]);
//echo "Uploaded and stored in: userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
$profile_pic_name = @$_FILES["profilepic"]["name"];
$profile_pic_query = mysql_query("UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username='$username'");
header("Location: account_settings.php");

}
}
else{
	
	echo "Invalid File! Your image must be no larger than 1Mb and it must be either a .jpg, .jpeg, .gif or .png";
	}
}

$submit = @$_POST['submit'];
$get_in = mysql_query("SELECT * FROM users WHERE username='$username'");
$get_r = mysql_fetch_assoc($get_in);
$db_dob = $get_r['dob'];
$db_school = $get_r['school'];
$db_clg = $get_r['clg'];
$db_hometown = $get_r['hometown'];
$db_currentcity = $get_r['currentcity'];
$db_relation = $get_r['relation'];
$db_work = $get_r['work'];
$db_mob = $get_r['mob'];
$db_link = $get_r['link'];
if($submit){

$dob= strip_tags(@$_POST['dob']);

$school = strip_tags(@$_POST['school']);
$clg = strip_tags(@$_POST['clg']);
$hometown = strip_tags(@$_POST['hometown']);
$currentcity = strip_tags(@$_POST['currentcity']);
$relation = strip_tags(@$_POST['relation']);
$work = strip_tags(@$_POST['work']);

$mob = strip_tags(@$_POST['mob']);
$link = strip_tags(@$_POST['link']);

	
		$info_update_query = mysql_query("UPDATE users SET  dob='$dob', school='$school', clg= '$clg', hometown='$hometown', currentcity='$currentcity', relation='$relation', work= '$work', mob= '$mob', link= '$link' WHERE username='$username'");
echo "Success!...Data updated successfully!";
}
else{
//do nothing
}


?>

<h2>Edit your Accounts Settings below</h2>
<hr />
<p> UPLOAD YOUR PROFILE PHOTO: </p><br />
<form action="" method="POST" enctype="multipart/form-data">
<img src="<?php echo $profile_pic; ?>" width="70"/>
<input type="file" name="profilepic" /><br />
<input type="submit" name="uploadpic" value="Upload Image" />
</form>
<br><hr />
<form action="account_settings.php" method="post">
<p>CHANGE YOUR PASSWORD:</p><br />
<label>Your Old Password:</label> <input type="password" name="oldpassword" id="oldpassword" size="40"><br />
<label>Your New Password:</label> <input type="password" name="newpassword" id="newpassword" size="40"><br />
<label>Re-type New Password: </label><input type="password" name="newpassword2" id="newpassword2" size="40"><br />

<input type="submit" name="senddata" id="senddata" value="Update Information">
</form>
<br><hr />
<form action="account_settings.php" method="post">
<p>UPDATE YOUR PROFILE:</p><br />
<label>First Name:</label> <input type="text" name="fname" id="fname" size="40" value="<?php echo $db_first_name ;?>"><br />
<label>Last Name:</label> <input type="text" name="lname" id="lname" size="40" value="<?php echo $db_last_name ;?>"><br />
<label>About You:</label> <textarea name="bio" id="bio" rows="7" cols="58"><?php echo $db_bio ;?></textarea><br />

<input type="submit" name="updateinfo" id="updateinfo" value="Update Information">
</form>
<br><hr />
 <form action="account_settings.php" method="POST" >
<p>PERSONAL DETAILS:</p><br>
             
                <p>
					<label for="dob">Date-of-Birth: </label>
					<input type="text" name="dob" value="<?php echo $db_dob ;?>">(e.g. 12-jan-1993 or 12-jan in case you want to hide your year of birth.)
				</p>
                
				<p>
					<label for="school">Schooling: </label>
					<input type="text" name="school" value="<?php echo $db_school ;?>">
				</p>
				<p>
					<label for="clg">College/University: </label>
					<input type="text" name="clg" value="<?php echo $db_clg ;?>">
				</p>
                <p>
					<label for="hometown">Home Town: </label>
					<input type="text" name="hometown" value="<?php echo $db_hometown ;?>">
				</p>
                <p>
					<label for="currentcity">Current City: </label>
					<input type="text" name="currentcity" value="<?php echo $db_currentcity ;?>">
				</p>
                <p>
					<label for="relation">Relationship Status: </label>
					<input type="text" name="relation" value="<?php echo $db_relation ;?>">
				</p>
                <p>
					<label for="work">	Presently Working at: </label>
					<input type="text" name="work" value="<?php echo $db_work ;?>">
				</p>
               
                 <p>
					<label for="mob">	Mobile Nos: </label>
					<input type="text" name="mob" value="<?php echo $db_mob ;?>">
				</p>
                 <p>
					<label for="text">	Your Links: </label>
                   <textarea name="link" id="link" rows="7" cols="58"><?php echo $db_link ;?></textarea>				
                </p>
				
				
				
				<p>
					<input type="submit" name="submit" value="Update Information">
				</p>
			</form>
<br><hr>




<form action="close_account.php" method="post">
<p>CLOSE ACCOUNT:</p><br />

<input type="submit" name="updateinfo" id="updateinfo" value="Close My Account">
</form>
<br />
<br />