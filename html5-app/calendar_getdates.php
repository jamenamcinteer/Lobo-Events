<?php
include('connect.php');

$display_date;
	
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
	
	$startdate = date("D, M j, Y; g:i a",$starttstamp);
	
	$enddate = date("l, F j, Y @ g:i a",$endtstamp);
	
	$maxchars = 300;
	$content = substr($description, 0, $maxchars);
	$content = $content . '...';
	
	$summary = $event->properties->summary->text;
	$image = $event->properties->attach->uri;
	$category = $event->properties->categories->text;
	$location = $event->properties->location->text;
	$id = $event->properties->uid->text;
	
	$time_limit = $current_date + 2629740;
	$time_limit = $current_date + 7889231;
	$time_limit = $current_date + 31556926;
	
	//if($starttstamp >= $current_date && $starttstamp < $time_limit){
	array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));
    	array_push($datesarray, $starttstamp);
    	//}
    	
   }
   
   array_multisort($datesarray, $eventsarray);
   
   
foreach ($eventsarray as $event) {
	$calendar_date = date(n . '/' . j . '/' . Y, $event['starttstamp']);
	$display_date .= "'$calendar_date',";
	/*echo '<h1 style="font-family:\'Century Gothic\',\'Muli\',Verdana,Arial,sans-serif;"><a style="color:#CE0F42;" href="event.php?id=' . $event['id'] . '">' . $event['summary'] . '</a></h1>';
	echo $event['location'] . '<br><br>';*/

}	


$display_date = substr($display_date, 0, -1);
echo $display_date;
?>