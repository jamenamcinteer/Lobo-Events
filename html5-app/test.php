<?php
include('connect.php');

$currenttime = time();

$my_file = 'cron.txt';
$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
$data = date(m . '/' . d . '/' . y, time()) . '\n';
fwrite($handle, $data);


$result = mysql_query("SELECT * FROM calendars WHERE starttstamp > '$currenttime' AND 1hr = 'yes' ORDER BY id ASC");
while($row = mysql_fetch_array($result)){

$sec_wk = 604800;
$sec_3day = 259200;
$sec_24hr = 86400;
$sec_3hr = 10800;
$sec_1hr = 3600;

$id = $row['id'];
$event_id = $row['event_id'];

fwrite($handle, $event_id . '\n');
fwrite($handle, mysql_error() . '\n\n');

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


$from = "notifications@unmevents.com";
$headers = "From:" . $from;

/*echo $row['email'] . '<br>';
echo $row['starttstamp'] . '<br>';
echo $currenttime . '<br>';
echo $sec_3hr . '<br>';
echo $row['starttstamp'] - $currenttime;*/

if($row['mobile'] != '' && $row['carrier'] != ''){$mobile_notif = $row['mobile'] . '@' . $row['carrier'];}
else $mobile_notif = '';

if($mobile_notif != ''){mail("$mobile_notif", "", "$summary at $location is starting on $startdate1 at $startdate2", "From: Lobo Events <notifications@unmevents.com>\r\n");}
echo $mobile_notif . '<br>';


}
?>