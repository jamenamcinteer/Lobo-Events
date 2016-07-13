<?php
include('connect.php');

if(isset($_POST['enter_date'])){
	$enter_date = mysql_real_escape_string($_POST['enter_date']);
	$enter_device = mysql_real_escape_string($_POST['enter_device']);
	
//$reg_id = $_COOKIE['reg_id'];
//$cookie_id = $_COOKIE['cookie_id'];
$user = $_COOKIE['auth_user'];

$currenttime = time();
$eventsarray = array();

$url="http://datastore.unm.edu/events/events.xml";
$events = simplexml_load_file($url);

/*if(!$reg_id){$result = mysql_query("SELECT * FROM calendars WHERE cookie_id = '$cookie_id' ORDER BY starttstamp DESC");}
if($reg_id){$result = mysql_query("SELECT * FROM calendars WHERE reg_id = '$reg_id' ORDER BY starttstamp DESC");}*/
$result = mysql_query("SELECT * FROM calendars WHERE user = '$user' ORDER BY starttstamp DESC");
while($row = mysql_fetch_array($result)){

$calendar_date = date(m . '/' . d . '/' . Y, $row['starttstamp']);
if($calendar_date == $enter_date){$event_id = $row['event_id'];}
else {$event_id = '';}

$sec_wk = 604800;
$sec_3day = 259200;
$sec_24hr = 86400;
$sec_3hr = 10800;
$sec_1hr = 3600;

$id = $row['id'];
//$event_id = $row['event_id'];

foreach ($events->vcalendar->components->vevent as $event) {	
	$starttstamp = strtotime($event->properties->dtstart->{'date-time'});
	if($starttstamp == 0 || $starttstamp == '')$starttstamp = strtotime($event->properties->dtstart->{'date'});
	$endtstamp = strtotime($event->properties->dtend->{'date-time'});
	if($endtstamp == 0 || $endtstamp == '')$endtstamp = strtotime($event->properties->dtend->{'date'});
	
	$startdate1 = date("l, F j, Y",$starttstamp);
	$startdate2 = date("g:i a",$starttstamp);
	$startdate = date("D, M j, Y g:i a",$starttstamp);
	$enddate = date("D, M j, Y g:i a",$endtstamp);
	$summary = $event->properties->summary->text;
	$location = $event->properties->location->text;

	$id = $event->properties->uid->text;
	
	if($id == $event_id){
	array_push($eventsarray, array('startdate1' => $startdate1,'startdate2' => $startdate2,'startdate' => $startdate,'enddate' => $enddate,'summary' => $summary,'location' => $location,'starttstamp' => $starttstamp,'id' => $id));}
   }
   
   
foreach ($eventsarray as $event) {
	$startdate1 = $event['startdate1'];
	$startdate2 = $event['startdate2'];
	$summary = $event['summary'];
	$location = $event['location'];
	
//Calculate difference
$diff=$event['starttstamp']-time();//time returns current time in seconds
$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
$hours=round(($diff-$days*60*60*24)/(60*60));
}


$from = "notifications@unmevents.com";
$headers = "From:" . $from;

/*echo $row['email'] . '<br>';
echo $row['starttstamp'] . '<br>';
echo $currenttime . '<br>';
echo $sec_3hr . '<br>';
echo $row['starttstamp'] - $currenttime;*/

if($event_id != ''){
	echo '<div class="list_event">';
	
	
	if($days == 0)echo '<div class="list_event_time">' . $hours . ' HRS</div>';
	if($days == 1 && $hours > 1)echo '<div class="list_event_time">' . $days . ' DAY<br>' . $hours . ' HRS</div>';
	if($days > 1 && $hours > 1)echo '<div class="list_event_time">' . $days . ' DAYS<br>' . $hours . ' HRS</div>';
	if($days == 1 && $hours <= 1)echo '<div class="list_event_time">' . $days . ' DAY<br>' . $hours . ' HR</div>';
	if($days > 1 && $hours <= 1)echo '<div class="list_event_time">' . $days . ' DAYS<br>' . $hours . ' HR</div>';
	echo '<h2 style="margin-right:65px;"><a href="event.php?id=' . $event['id'] . '">' . $event['summary'] . '</a></h2>';
	//echo '<h3>' . $event['startdate'] . '</h3>';
	
	if($event['startdate'] != $event['enddate'] && $event['enddate'] != 'Wed, Dec 31, 1969 5:00 pm')echo '<h3 style="margin-right:85px;">' . $event['startdate'] . ' - ' . $event['enddate'];
	else echo '<h3 style="margin-right:85px;">' . $event['startdate'];
	echo '</h3>';
	if($event['location'] != 'Not Specified'){echo"<span class='list_event_loc' style='margin-right:55px;'>" . $event['location'] . "</span>";}

	echo '</div>';
	
}


}

if(empty($eventsarray)){echo '<h2>There are no events in your calendar starting ' . $enter_date . '.</h2>';}
}
if(($_POST['enter_date']) == ''){
	echo '';
}

?>