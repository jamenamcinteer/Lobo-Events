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
    ADD TO CALENDAR &#9660;</span>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="min-width:250px;right:40%;">
    <li role="presentation"><a role="menuitem" tabindex="-1" href="event.php?id=<?php echo $eventid;?>">Event Description</a></li>
    <!--<li role="presentation"><a role="menuitem" tabindex="-1" href="event_map.php?id=<?php echo $eventid;?>">Event Location</a></li>-->
    <li role="presentation"><a role="menuitem" tabindex="-1" href="add.php?id=<?php echo $eventid;?>">Add to Calendar</a></li>
  </ul>
</div>
<div id="dropdown-wide">
<h2>ADD TO CALENDAR</h2>
&#9660;
  <ul>
    <li><a href="event.php?id=<?php echo $eventid;?>">Event Description</a></li>
    <!--<li><a href="event_map.php?id=<?php echo $eventid;?>">Event Location</a></li>-->
    <li><a href="add.php?id=<?php echo $eventid;?>">Add to Calendar</a></li>
    <?php if($user){?><li><a href="settings.php"><br>My Settings</a></li><?php }?>
  </ul>
</div>

</div><!-- #nav_top -->

<div id="content" style="margin-top:45px;">
<?php
$url="http://datastore.unm.edu/events/events.xml";
$events = simplexml_load_file($url);
$eventsarray = array();
foreach ($events->vcalendar->components->vevent as $event) {	
	$starttstamp = strtotime($event->properties->dtstart->{'date-time'});
	if($starttstamp == 0 || $starttstamp == '')$starttstamp = strtotime($event->properties->dtstart->{'date'});
	
	$startdate1 = date("l, F j, Y",$starttstamp);
	$startdate2 = date("g:i a",$starttstamp);
	$summary = $event->properties->summary->text;
	$location = $event->properties->location->text;

	$id = $event->properties->uid->text;
	
	if($id == $event_id){
	array_push($eventsarray, array('startdate1' => $startdate1,'startdate2' => $startdate2,'summary' => $summary,'location' => $location));}
   }
   
   
foreach ($eventsarray as $event) {
	$startdate1 = $event['startdate1'];
	$startdate2 = $event['startdate2'];
	$summary = $event['summary'];
	$location = $event['location'];
}
?>
<div  class="event" style="padding:20px;">
<?php
echo '<h2>' . $summary . '</h2>';
?>
<!-- style="background:url(img/semitrans1.png) repeat;margin-top:-10px;padding:20px;padding-bottom:120px;" -->



<?php
$result_user = mysql_query("SELECT * FROM users WHERE email = '$user' LIMIT 1");
$uinfo = mysql_fetch_assoc($result_user);
$uname = $uinfo['name'];
$umobile = $uinfo['mobile'];
$ucarrier = $uinfo['carrier'];
$uid = $uinfo['id'];

if(isset($_POST['submitCalendar'])){

//$email = $_POST['email'];
//$mobile = db_clean($_POST['mobile']);
//$carrier = db_clean($_POST['carrier']);
$notif = $_POST['notif'];
$notif_destination = $_POST['notif_destination'];
$notif_device = $_POST['notif_device'];
//$cookie_id = $_COOKIE['cookie_id'];
//$device_id = $_POST['device_id'];

$t1wk = 'no';
$t3day = 'no';
$t24hr = 'no';
$t3hr = 'no';
$t1hr = 'no';

if($notif != ''){
foreach($notif as $notifyn){
	if($notifyn == '1wk')$t1wk = 'yes';
	if($notifyn == '3day')$t3day = 'yes';
	if($notifyn == '24hr')$t24hr = 'yes';
	if($notifyn == '3hr')$t3hr = 'yes';
	if($notifyn == '1hr')$t1hr = 'yes';
}
}

if($notif_destination != ''){
foreach($notif_destination as $notiftype){
	if($notiftype == 'email')$email = $user;
	if($notiftype == 'mobile')$mobile = $umobile;$carrier = $ucarrier;
}
}

if($notif_device != ''){
foreach($notif_device as $ndevice){
	$result_device = mysql_query("SELECT * FROM user_devices WHERE id = '$ndevice' LIMIT 1");
	$dinfo = mysql_fetch_assoc($result_device);
	$dreg_id = $dinfo['reg_id'];
	
	$insert = mysql_query("INSERT INTO calendar_devices (event_id, reg_id, user) VALUES ('$event_id','$dreg_id','$user')");
}
}

//NEED STARTTSTAMP OF EVENT
$url="http://datastore.unm.edu/events/events.xml";
$events = simplexml_load_file($url);

$eventsarray = array();

foreach ($events->vcalendar->components->vevent as $event) {	
	$starttstamp = strtotime($event->properties->dtstart->{'date-time'});
	if($starttstamp == 0 || $starttstamp == '')$starttstamp = strtotime($event->properties->dtstart->{'date'});

	$id = $event->properties->uid->text;
	
	if($id == $event_id){
	array_push($eventsarray, array('starttstamp' => $starttstamp));}
   }
   
   
foreach ($eventsarray as $event) {
	$starttstamp = $event['starttstamp'];
}
//ONLY ADD A NOTIFICATION IF THERE IS ENOUGH TIME BEFORE THE EVENT FOR IT TO GO OFF
$currenttime = time();
if(($starttstamp - $currenttime) < 597600){$t1wk = 'no';}
if(($starttstamp - $currenttime) < 252000){$t3day = 'no';}
if(($starttstamp - $currenttime) < 79200){$t24hr = 'no';}
if(($starttstamp - $currenttime) < 3600){$t3hr = 'no';}

//if($reg_id){$cookie_id = '';}

//GET THE MOBILE CARRIER IF THERE IS ONE
if($carrier != ''){$result = mysql_query("SELECT * FROM gateway WHERE carrier = '$carrier' LIMIT 1");
while($row = mysql_fetch_array($result)){
$carrier_address = $row['address'];
}
}
else $carrier_address = '';

//WHEN SUBMIT BUTTON IS PRESSED, ADD TO 'CALENDARS' TABLE THE DEVICE (OR COOKIE) ID, THE EVENT ID (FROM GET), THE UNIX TIMESTAMP OF THE START OF THE EVENT, AND THE INFO ENTERED BY THE USER. ADD THIS INFO TO THE DATABASE. ANOTHER PAGE (CALENDAR.PHP) WILL DISPLAY ALL EVENTS A DEVICE (OR BROWSER, BASED ON COOKIE ID) HAS ADDED TO THE CALENDAR. A CRON WILL RUN HOURLY AND SEND E-MAIL (AND HOPEFULLY PUSH) NOTIFICATIONS TO THE USERS DEPENDING ON THE TIMESTAMP ENTERED AND HOW OFTEN THE NOTIFICATIONS WERE REQUESTED BY THE USER.
$sql_request = "INSERT INTO calendars (user,event_id,starttstamp,1wk,3day,24hr,3hr,1hr,email,mobile,carrier) VALUES ('$user','$event_id','$starttstamp','$t1wk','$t3day','$t24hr','$t3hr','$t1hr','$email','$mobile','$carrier_address')";
$result = mysql_query($sql_request);

//SEND E-MAIL TO E-MAIL ADDRESS LETTING USER KNOW THAT THE EVENT AND E-MAIL HAS BEEN ADDED TO THE CALENDAR
echo '<div class="success">Event successfully added to calendar. <a href="calendar_my.php">View Calendar</a></div>';
}
?>

<?php if($user == 'NONE'){?><div class="nonandroid">This feature is disabled for non-registered users. Would you like to <a href="index.php?cmd=REGNOW">register now</a> (cookies must be enabled)?</div><?php }?>

<?php if($user != 'NONE'){?>
<form action="add.php?id=<?php echo $event_id;?>" method="post">
<em style="color:gray;">All fields are optional.</em><br><br>

<label for="check_email"><input type="checkbox" name="notif_destination[]" value="email" id="check_email"><span class="notif"> Send e-mail notifications to <?php echo $user;?></span></label><br>

<?php if($umobile && $ucarrier){?>
<label for="check_mobile"><input type="checkbox" name="notif_destination[]" value="mobile" id="check_mobile"><span class="notif"> Send text notifications to <?php echo $umobile;?>*</span></label><br><?php }?>

<?php
$result_device = mysql_query("SELECT * FROM user_devices WHERE user_id = '$uid'");
while($device = mysql_fetch_assoc($result_device)){
echo '
<label for="check_' . $device['id'] . '"><input type="checkbox" name="notif_device[]" value="' . $device['id'] . '" id="check_' . $device['id'] . '"><span class="notif"> Send device notifications to ' . $device['device_name'] . '</span></label><br>
';
}
?>

<?php if($umobile && $ucarrier){?><em style="color:#CE0F42;font-size:10px;">*Data rates may apply.</em><?php }?>

<div id="phone-notifications">
<br><strong style="color:#CE0F42;">Set reminders:</strong><br>

<style type="text/css">
.notif {padding:10px;font-size:16px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;}
</style>

<label for="check_1wk"><input type="checkbox" name="notif[]" value="1wk" id="check_1wk"><span class="notif"> 1 week </span></label>
<label for="check_3day"><input type="checkbox" name="notif[]" value="3day" id="check_3day"><span class="notif"> 3 days </span></label>
<label for="check_24hr"><input type="checkbox" name="notif[]" value="24hr" id="check_24hr"><span class="notif"> 24 hours </span></label>
<label for="check_3hr"><input type="checkbox" name="notif[]" value="3hr" id="check_3hr"><span class="notif"> 3 hours </span></label>
<label for="check_1hr"><input type="checkbox" name="notif[]" value="1hr" id="check_1hr"><span class="notif"> 1 hour</span></label>
</div><br>
<input type="submit" name="submitCalendar" value="Add Event to Calendar" style="background:#CE0F42;color:white;text-align:center;text-transform:uppercase;padding:10px;font-size:16px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;max-width:300px;border:0;">

<input type="hidden" name="device_id" id="device_id">
</form>
<?php }?>
</div>  
  

  
</div>  
  

<?php $nav_bottom_page = 'calendar';?>
<?php }?>
<?php include('footer.php');?>