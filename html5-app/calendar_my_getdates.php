<?php
include('connect.php');

$currenttime = time();
$display_date;

//$reg_id = $_COOKIE['reg_id'];
//$cookie_id = $_COOKIE['cookie_id'];
$user = $_COOKIE['auth_user'];

/*if(!$reg_id){$result = mysql_query("SELECT * FROM calendars WHERE starttstamp > '$currenttime' && cookie_id = '$cookie_id' ORDER BY id ASC");}
if($reg_id){$result = mysql_query("SELECT * FROM calendars WHERE starttstamp > '$currenttime' && reg_id = '$reg_id' ORDER BY id ASC");}*/
$result = mysql_query("SELECT * FROM calendars WHERE starttstamp > '$currenttime' && user = '$user' ORDER BY id ASC");

while($row = mysql_fetch_array($result)){

$sec_wk = 604800;
$sec_3day = 259200;
$sec_24hr = 86400;
$sec_3hr = 10800;
$sec_1hr = 3600;

$id = $row['id'];
$event_id = $row['event_id'];


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

//echo $startdate1;
$calendar_date = date(n . '/' . j . '/' . Y, $row['starttstamp']);
$display_date .= "'$calendar_date',";

//'12/27/2013',




}
$display_date = substr($display_date, 0, -1);
echo $display_date;
?>