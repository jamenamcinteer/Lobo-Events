<div id="login_page" style="width:90%;max-width:400px;margin:auto;margin-top:7%;padding:10px;">
<h1>Register or Log In</h1>
<h3>This step is not necessary, but some features are only available after login.</h3>
<?php if($error){echo "<p style='color:red;text-align:center;font-weight:bold;'>$error</p>";}?>
<p id="blank_fields" style="color:red;text-align:center;font-weight:bold;display:none;">Please fill out all fields.</p>
<form action="index.php" method="post" style="padding:20px;" id="form_login">

<h2>E-mail</h2>
<input type="email" name="email" id="email" placeholder="E-mail address" style="width:90%;max-width:300px;padding:10px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;border-radius:0;">

<h2>Password</h2>
<input type="password" name="password" id="password" style="width:90%;max-width:300px;padding:10px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;border-radius:0;">

<?php
//IF THERE IS A REGISTRATION AND ID AND IF THIS REG ID IS NOT ALREADY IN THE DB
if($reg_id){
$result = mysql_query("SELECT id FROM user_devices WHERE reg_id = '$reg_id' LIMIT 1");
	while ($row = mysql_fetch_assoc($result)) {$device_id = $row['id'];}
	if(!$device_id){
?>
<h2>Device Name</h2>
<input type="text" name="device_name" id="device_name" placeholder="My Device Name" style="width:90%;max-width:300px;padding:10px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;border-radius:0;">
<input type="hidden" name="device_version" id="device_version">
<?php
		}
	}
?>

<input type="submit" name="submitLogin" value="Continue" style="background:#CE0F42;color:white;text-align:center;text-transform:uppercase;padding:10px;font-size:16px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;max-width:322px;border:0;"> <a href="index.php?cmd=NOAUTH" style="margin-left:30px;">Skip this step &raquo;</a>

</form>
</div>