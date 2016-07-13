<?php
include('connect.php');

$eventsarray = array();
$datesarray = array();
$display_locsB;
$current_date = time();
$filter_time = 'ALL EVENTS AT UNM';

	if($filter_time == 'NEXT 3 DAYS AT UNM')$time_limit = $current_date + 259200;
	if($filter_time == 'THIS WEEK AT UNM')$time_limit = $current_date + 604800;
	if($filter_time == 'THIS MONTH AT UNM')$time_limit = $current_date + 2629740;
    	
    	

/*if($filter_time != 'ALL EVENTS AT UNM'){
$result_events = mysql_query("SELECT * FROM map_events WHERE starttstamp >= $current_date AND $starttstamp < $time_limit");}
if($filter_time == 'ALL EVENTS AT UNM' || $filter_time == ''){
$result_events = mysql_query("SELECT * FROM map_events WHERE starttstamp >= $current_date");}*/
$eventid = $_GET['id'];
$result_events = mysql_query("SELECT * FROM map_events WHERE event_id = '$eventid'");
while($event = mysql_fetch_assoc($result_events)){
$event_id = $event['event_id'];
$location_name = $event['location_name'];
$loc_lat = $event['lat'];
$loc_long = $event['long'];

$url="http://datastore.unm.edu/events/events.xml";
$events = simplexml_load_file($url);
$eventsarray = array();
$this_event = 'no';//now, today, no - will it be displayed
foreach ($events->vcalendar->components->vevent as $event) {
	$starttstamp = strtotime($event->properties->dtstart->{'date-time'});
	if($starttstamp == 0 || $starttstamp == '')$starttstamp = strtotime($event->properties->dtstart->{'date'});
	
	$endtstamp = strtotime($event->properties->dtend->{'date-time'});
	if($endtstamp == 0 || $endtstamp == '')$endtstamp = strtotime($event->properties->dtend->{'date'});
	
	$startdate = date("D, g:i a",$starttstamp);
	
	$enddate = date("D, g:i a",$endtstamp);
	
	$summary = $event->properties->summary->text;
	$id = $event->properties->uid->text;
	//86400
	
	/*array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));*/
	if($id == $event_id){
		if($starttstamp <= $current_date && $endtstamp >= $current_date){$this_event = 'now';$this_summary = $summary;$this_startdate = $startdate;$this_enddate = $enddate;}
		if($starttstamp > $current_date && $starttstamp <= ($current_date + 86400)){$this_event = 'later';$this_summary = $summary;$this_startdate = $startdate;$this_enddate = $enddate;}
	}
	}

if($this_event == 'now'){
$display_locsB .= "['<div><strong><a href=\"event.php?id=$event_id\">$this_summary</a></strong><br><em>$this_startdate - $this_enddate</em><br>$location_name</div>',$loc_lat,$loc_long,'img/mapicon2.png'], ";
}
if($this_event == 'later'){
$display_locsB .= "['<div><strong><a href=\"event.php?id=$event_id\">$this_summary</a></strong><br><em>$this_startdate - $this_enddate</em><br>$location_name</div>',$loc_lat,$loc_long,'img/mapicon1.png'], ";
}

//$display_locsB .= " ['<div style=\"width:200px;\"><strong>$event_title</strong><br>$data_loc</div>',$loc_lat,$loc_long,1], ";

}

$display_locsB = substr($display_locsB, 0, -1);
echo $display_locsB;


?>