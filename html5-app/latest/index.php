<?php include('login_process.php');?>
<?php include('header.php');?>

<?php if(!$user){?>
<?php include('login.php');?>
<?php }?>


<?php if($user){?>
<?php $filter_time = $_GET['filter_time'];if($filter_time == '')$filter_time = 'THIS MONTH AT UNM';?>
<div id="nav_top">
<img src="img/icon_45px.png" id="site_icon" alt="Lobo Events">
<?php if($user){?><a href="settings.php"><img src="img/icon_settings.png" id="settings_icon" alt="Settings"></a><?php }?>
<div class="dropdown">
<span id="dropdownMenu1" data-toggle="dropdown">
    UNM Events List</span>
</div>
<div id="dropdown-wide">
<h2>UNM Events List</h2>
  <ul>
    <?php if($user){?><li><a href="settings.php"><br>My Settings</a></li><?php }?>
  </ul>
</div>

</div><!-- #nav_top -->

<div id="content">

<h1>Events at UNM</h1>
<form><p style="padding:10px;"><strong>Search by date:</strong><br><input type="text" name="from" id="dateFrom" placeholder="From" style="border-radius:0;">
<input type="text" name="to" id="dateTo" placeholder="To" style="border-radius:0;">
<input type="submit" name="submitSearch" value="Search" style="background:#CE0F42;color:white;text-align:center;text-transform:uppercase;padding:5px;font-size:16px;font-family:'Muli','Century Gothic',Verdana,Arial,Tahoma,sans-serif;max-width:300px;border:0;margin-top:-10px;"></p>
</form>
<?php
$url="http://datastore.unm.edu/events/events.xml";

$events = simplexml_load_file($url);

//echo $events->vcalendar->components->vevent[0]->properties->categories->text;

$eventsarray = array();
$datesarray = array();

foreach ($events->vcalendar->components->vevent as $event) {
	$description = str_replace('\n','<br>',$event->properties->description->text);
	
	$current_date = time();
	
	$starttstamp = strtotime($event->properties->dtstart->{'date-time'});
	if($starttstamp == 0 || $starttstamp == '')$starttstamp = strtotime($event->properties->dtstart->{'date'});
	
	$endtstamp = strtotime($event->properties->dtend->{'date-time'});
	if($endtstamp == 0 || $endtstamp == '')$endtstamp = strtotime($event->properties->dtend->{'date'});
	
	$startdate = date("D, M j, Y g:i a",$starttstamp);
	
	$enddate = date("D, M j, Y g:i a",$endtstamp);
	
	$maxchars = 300;
	$content = substr($description, 0, $maxchars);
	$content = $content . '...';
	
	$summary = $event->properties->summary->text;
	$image = $event->properties->attach->uri;
	$category = $event->properties->categories->text;
	$location = $event->properties->location->text;
	$id = $event->properties->uid->text;
	
	$from = $_GET['from'];
	$to = $_GET['to'];
	$from = strtotime($from, time());
	$to = strtotime($to, time());
	if($from && $to){
		if($starttstamp >= $from && $starttstamp <= $to || $starttstamp < $from && $endtstamp > $to){
		array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));
    	array_push($datesarray, $starttstamp);
		}
	}
	if($from && !$to){
		if($starttstamp >= $from || $endtstamp > $from){
		array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));
    	array_push($datesarray, $starttstamp);
		}
	}
	if($to && !$from){
		if($starttstamp <= $to){
		array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));
    	array_push($datesarray, $starttstamp);
		}
	}
	$time_limit = $current_date + 2629740;
	if(!$from && !$to){
	if($starttstamp >= $current_date && $starttstamp < $time_limit ||  $starttstamp < $current_date && $endtstamp > $current_date){
	array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));
    	array_push($datesarray, $starttstamp);}
	}
	
	/*if($filter_time == 'NEXT 3 DAYS AT UNM')$time_limit = $current_date + 259200;
	if($filter_time == 'THIS WEEK AT UNM')$time_limit = $current_date + 604800;
	if($filter_time == 'THIS MONTH AT UNM')$time_limit = $current_date + 2629740;
	if($filter_time != 'ALL EVENTS AT UNM'){if($starttstamp >= $current_date && $starttstamp < $time_limit){
	array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));
    	array_push($datesarray, $starttstamp);}}
    	if($filter_time == 'ALL EVENTS AT UNM'){if($starttstamp >= $current_date){
	array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));
    	array_push($datesarray, $starttstamp);}}*/
   }
   
   array_multisort($datesarray, $eventsarray);
   
$currentDate = false;   
foreach ($eventsarray as $event) {
$current_date = time();
if($event['starttstamp'] >= $from && $event['starttstamp'] >= $current_date){
if(date(d, $event['starttstamp']) != $currentDate){echo '<h2 class="dateList">' . date("l, F j, Y", $event['starttstamp']) . '</h2>';
$currentDate = date(d, $event['starttstamp']);
}
}
if($event['starttstamp'] < $from) {
if($currentDate == false){
echo '<h2 class="dateList">Ongoing Events</h2>';
$currentDate = 'Ongoing Events';
}
}
if($event['starttstamp'] < $current_date) {
if($currentDate == false){
echo '<h2 class="dateList">Ongoing Events</h2>';
$currentDate = 'Ongoing Events';
}
}
//Calculate difference
$diff=$event['starttstamp']-time();//time returns current time in seconds
$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
$hours=round(($diff-$days*60*60*24)/(60*60));


?>
<div class="list_event">
<?php
	//echo '<div style="margin-right:3%;background-color:#E6E7E8;background-image:url(' . $event['image'] . ');" class="event_img"></div>';
	//echo '<div style="width:50px;float:right;z-index:20;"><div style="background-color:#58595B;text-align:center;color:white;">34 hrs.</div><a href="add.php?id=' . $event['id'] . '"><img src="img/event_add.png"></a></div>';
	if($days == 0)echo '<div class="list_event_time">' . $hours . ' HRS</div>';
	if($days == 1 && $hours > 1)echo '<div class="list_event_time">' . $days . ' DAY<br>' . $hours . ' HRS</div>';
	if($days > 1 && $hours > 1)echo '<div class="list_event_time">' . $days . ' DAYS<br>' . $hours . ' HRS</div>';
	if($days == 1 && $hours <= 1)echo '<div class="list_event_time">' . $days . ' DAY<br>' . $hours . ' HR</div>';
	if($days > 1 && $hours <= 1)echo '<div class="list_event_time">' . $days . ' DAYS<br>' . $hours . ' HR</div>';
	echo '<h2 style="margin-right:65px;"><a href="event.php?id=' . $event['id'] . '">' . $event['summary'] . '</a></h2>';
	//echo '<h3>' . $event['startdate'] . '</h3>';
	
	if($event['startdate'] != $event['enddate'])echo '<h3 style="margin-right:85px;">' . $event['startdate'] . ' - ' . $event['enddate'];
	else echo '<h3 style="margin-right:85px;">' . $event['startdate'];
	echo '</h3>';
	if($event['location'] != 'Not Specified'){echo"<span class='list_event_loc' style='margin-right:55px;'>" . $event['location'] . "</span>";}
	
	$curevent_id = $event['id'];
	//if(!$reg_id){$result = mysql_query("SELECT id FROM calendars WHERE cookie_id = '$cookie_id' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");}
	if($reg_id){$result = mysql_query("SELECT id FROM calendars WHERE reg_id = '$reg_id' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");}
	if($user != 'NONE'){$result = mysql_query("SELECT id FROM calendars WHERE user = '$user' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");
	$row = mysql_fetch_row($result);
	if($row[0] != ''){echo '<div class="list_event_add"><img src="img/button_add_done.png" alt="Added to Calendar"></div>';}
	if($row[0] == ''){echo '<div class="list_event_add"><a href="add.php?id=' . $event['id'] . '"><img src="img/button_add.png" alt="Add to Calendar"></a></div>';}
	}
	if($user == 'NONE'){echo '<div class="list_event_add"><a href="add.php?id=' . $event['id'] . '"><img src="img/button_add.png" alt="Add to Calendar"></a></div>';}
	
	//echo '<div style="background:url(img/semitrans2.png);padding:5px;text-align:right;margin:0px 15px 15px 15px;margin:0;position:absolute;bottom:0;width:100%;">' . $event['startdate'] . '</div>';
	echo '</div>';
?>
<?php	

	   }
?>
    
   

</div>

<?php $nav_bottom_page = 'list';?>
<?php }?>
<?php include('footer.php');?>