<?php include('login_process.php');?>
<?php include('header.php');?>

<?php if(!$user){?>
<?php include('login.php');?>
<?php }?>


<?php if($user){?>

<div id="nav_top">
<img src="img/icon_45px.png" id="site_icon" alt="Lobo Events">
<?php if($user){?><a href="settings.php"><img src="img/icon_settings.png" id="settings_icon" alt="Settings"></a><?php }?>
<div class="dropdown">
<span id="dropdownMenu1" data-toggle="dropdown">
    MY SETTINGS</span>
</div>
<div id="dropdown-wide">
<h2>MY SETTINGS</h2>
</div>

</div><!-- #nav_top -->
<?php
if(isset($_POST['submitSave'])){
$name = db_clean($_POST['name']);
$mobile = db_clean($_POST['mobile']);
$carrier = db_clean($_POST['carrier']);

if($name){$result = mysql_query("UPDATE users SET name = '$name' WHERE email = '$user'");}
if($mobile){$result = mysql_query("UPDATE users SET mobile = '$mobile' WHERE email = '$user'");}
if($carrier){$result = mysql_query("UPDATE users SET carrier = '$carrier' WHERE email = '$user'");}
}
if($app_ver != '' && $reg_id != ''){$result = mysql_query("UPDATE user_devices SET app_version = '$app_ver' WHERE reg_id = '$reg_id'");}
$result = mysql_query("SELECT * FROM users WHERE email = '$user' LIMIT 1");
$uinfo = mysql_fetch_assoc($result);
$uname = $uinfo['name'];
$umobile = $uinfo['mobile'];
$ucarrier = $uinfo['carrier'];
$uid = $uinfo['id'];
?>
<div id="content" style="margin-top:45px;margin-bottom:120px;">

<div  class="event" style="padding:20px;">
<h1>App Settings</h1>
<?php if(isset($_POST['submitSave'])){echo '<div class="nonandroid">Changes have been saved.</div>';}?>

<?php if($user == 'NONE'){?><div class="nonandroid">This feature is disabled for non-registered users. Would you like to <a href="index.php?cmd=REGNOW">register now</a> (cookies must be enabled)?</div><?php }?>

<?php if($user != 'NONE'){?>
<form action="settings.php" method="post">
<span class="notif"><strong>E-mail address:</strong> <?php echo $user;?></span><br><br>

<strong style="color:#CE0F42;">Registered Devices</strong><br>
<?php
$result_device = mysql_query("SELECT * FROM user_devices WHERE user_id = '$uid'");
while($device = mysql_fetch_assoc($result_device)){
echo '<span class="notif"><strong>Device Name:</strong> ' . $device['device_name'] . ' | <strong>Device Version:</strong> Android ' . $device['device_version'] . ' | <strong>App Version:</strong> ' . $device['app_version'];
if($device['app_version'] != '1.0.4' && $device['app_version'] != '1.0.5'){echo ' <span style="color:red;"> (Needs Updating)</span>';}//UPDATE VERSION WHEN PUBLISHED TO GOOGLE PLAY
if($device['app_version'] == '1.0.5'){echo ' <span style="color:green;"> (BETA)</span>';}//UPDATE VERSION WHEN PUBLISHED TO GOOGLE PLAY
if($device['app_version'] == '1.0.4'){echo ' <span style="color:green;"> (Latest)</span>';}//UPDATE VERSION WHEN PUBLISHED TO GOOGLE PLAY
echo'</span><br>';
}
if(mysql_num_rows($result_device) < 1) {echo '<em>No registered devices.</em><br>';}
?>
<br>

<strong style="color:#CE0F42;">Name</strong><br>
<input type="text" name="name" value="<?php echo $uname;?>" placeholder="Your Name" style="width:95%;max-width:300px;padding:10px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;border-radius:0;"> <br><br>

<strong style="color:#CE0F42;">Mobile phone to send text nofitications*</strong><br>
<input type="tel" id="mobile" name="mobile" value="<?php echo $umobile;?>" placeholder="Number" style="width:45%;max-width:150px;padding:10px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;border-radius:0;">
<select name="carrier" style="width:45%;max-width:150px;height:40px;padding:10px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;border-radius:0;"><option value="">Carrier</option><?php include('add_getcarriers.php');?></select>
<!--<input type="text" id="tags" name="carrier" placeholder="Carrier" style="width:45%;max-width:150px;height:40px;padding:10px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;border-radius:0;">-->
<br><em style="color:#CE0F42;font-size:10px;">*Data rates may apply.</em>

<br><br>
<input type="submit" name="submitSave" value="Save Changes" style="background:#CE0F42;color:white;text-align:center;text-transform:uppercase;padding:10px;font-size:16px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;max-width:300px;border:0;">

</form>
<?php }?>



</div>

</div>

<?php }?>
<?php include('footer.php');?>