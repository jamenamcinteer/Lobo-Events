<?php
include('connect.php');
$user = $_COOKIE['auth_user'];
$enter_date = $_POST['enter_date'];
	
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
	
	$calendar_date = date(m . '/' . d . '/' . Y, $starttstamp);
	$entertstamp = strtotime($enter_date, time());
	
	if($calendar_date == $enter_date || $starttstamp < $entertstamp && $endtstamp > $entertstamp){
	array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $content, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));
    	array_push($datesarray, $starttstamp);}
   }
   
   array_multisort($datesarray, $eventsarray);
   
   
foreach ($eventsarray as $event) {
//Calculate difference
$diff=$event['starttstamp']-time();//time returns current time in seconds
$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
$hours=round(($diff-$days*60*60*24)/(60*60));

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
	
	$curevent_id = $event['id'];
	//if(!$reg_id){$result = mysql_query("SELECT id FROM calendars WHERE cookie_id = '$cookie_id' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");}
	if($reg_id){$result = mysql_query("SELECT id FROM calendars WHERE reg_id = '$reg_id' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");}
	if($user != 'NONE'){$result = mysql_query("SELECT id FROM calendars WHERE user = '$user' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");
	$row = mysql_fetch_row($result);
	if($row[0] != ''){echo '<div class="list_event_add"><img src="img/button_add_done.png"></div>';}
	if($row[0] == ''){echo '<div class="list_event_add"><a href="add.php?id=' . $event['id'] . '"><img src="img/button_add.png"></a></div>';}
	}
	if($user == 'NONE'){echo '<div class="list_event_add"><a href="add.php?id=' . $event['id'] . '"><img src="img/button_add.png" alt="Add to Calendar"></a></div>';}
	echo '</div>';

}
if(empty($eventsarray)){echo '<h2>There are no events starting ' . $enter_date . '.</h2>';}

?>