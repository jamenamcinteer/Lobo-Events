<?php

include('connect.php');

$currenttime = time();

/*$my_file = 'cron.txt';
$handle = fopen($my_file, 'a') or die('Cannot open file:  ' . $my_file);
$data = date(m . '/' . d . '/' . y, time()) . '\n';
fwrite($handle, $data);*/


$result = mysql_query("SELECT * FROM calendars WHERE starttstamp > '$currenttime' AND 1hr = 'yes' ORDER BY id ASC") or die(mysql_error());
//echo mysql_num_rows($result);
while ($row = mysql_fetch_array($result)) {
echo $row['id'] . '<br>';

    $sec_wk = 604800;
    $sec_3day = 259200;
    $sec_24hr = 86400;
    $sec_3hr = 10800;
    $sec_1hr = 3600;

    $cal_id = $row['id'];
    $event_id = $row['event_id'];
    $user = $row['user'];

    /*fwrite($handle, $event_id . '\n');
    fwrite($handle, mysql_error() . '\n\n');*/

    $url = "http://datastore.unm.edu/events/events.xml";
    $events = simplexml_load_file($url);
    $eventsarray = array();
    foreach ($events->vcalendar->components->vevent as $event) {
        $starttstamp = strtotime($event->properties->dtstart->{'date-time'});
        if ($starttstamp == 0 || $starttstamp == '')
            $starttstamp = strtotime($event->properties->dtstart->{'date'});

        $startdate1 = date("l, F j, Y", $starttstamp);
        $startdate2 = date("g:i a", $starttstamp);
        $summary = $event->properties->summary->text;
        $location = $event->properties->location->text;

        $id = $event->properties->uid->text;

        if ($id == $event_id) {
            array_push($eventsarray, array('startdate1' => $startdate1, 'startdate2' => $startdate2, 'summary' => $summary, 'location' => $location));
        }
    }


    foreach ($eventsarray as $event) {
        $startdate1 = $event['startdate1'];
        $startdate2 = $event['startdate2'];
        $summary = $event['summary'];
        $location = $event['location'];
    }


    $from = "notifications@unmevents.com";
    $headers = "From:" . $from;

    /* echo $row['email'] . '<br>';
      echo $row['starttstamp'] . '<br>';
      echo $currenttime . '<br>';
      echo $sec_3hr . '<br>';
      echo $row['starttstamp'] - $currenttime; */

    if ($row['mobile'] != '' && $row['carrier'] != '') {
        $mobile_notif = $row['mobile'] . '@' . $row['carrier'];
    }
    else
        $mobile_notif = '';
        
        echo $mobile_notif . '<br>';
        
        
        if($location != 'Not Specified'){$send_message = "$summary at $location is starting on $startdate1 at $startdate2";}
        if($location == 'Not Specified'){$send_message = "$summary is starting on $startdate1 at $startdate2";}

//FIND RECORDS THAT NEED NOTIFICATIONS TO BE SENT
    if ($row['1wk'] == 'yes' && (($row['starttstamp'] - $currenttime) >= $sec_wk) && (($row['starttstamp'] - $currenttime) <= ($sec_wk + 3600))) {
//SEND 1 WEEK NOTIFICATION
//'Event' at 'UNM Sub' is starting on Wednesday, November 1, 2013 at 8:00 pm.
        echo '1wk = yes' . $row['email'] . $id;
        //SEND NOTIFICATION EMAIL
        if ($row['email']) {
            mail($row['email'], $send_message, $send_message, $headers);
        }
        //SEND NOTIFICATION TEXT MESSAGE
        if ($mobile_notif != '') {
            mail("$mobile_notif", "", $send_message, "From: Lobo Events <notifications@unmevents.com>\r\n");
        }
        //SEND PUSH NOTIFICATION WITH ABOVE MESSAGE
        $result_device = mysql_query("SELECT * FROM calendar_devices WHERE event_id = '$event_id' AND user = '$user'");
	while($device = mysql_fetch_assoc($result_device)){
		sendPushNotification($send_message,$device['reg_id']);
	}
        //UPDATE RECORD SO MULTIPLE NOTIFICATIONS AREN'T SENT
        $query = mysql_query("UPDATE calendars SET 1wk = 'no' WHERE id = '$cal_id'");
    }
        
        
    if ($row['3day'] == 'yes' && $row['1wk'] == 'no' && (($row['starttstamp'] - $currenttime) >= $sec_3day) && (($row['starttstamp'] - $currenttime) <= ($sec_3day + 3600))) {
//SEND 3 DAY NOTIFICATION
        echo '3day = yes' . $row['email'] . $event_id;
        //SEND NOTIFICATION EMAIL
        if ($row['email']) {
            mail($row['email'], $send_message, $send_message, $headers);
        }
        //SEND NOTIFICATION TEXT MESSAGE
        if ($mobile_notif != '') {
            mail("$mobile_notif", "", $send_message, "From: Lobo Events <notifications@unmevents.com>\r\n");
        }
        //SEND PUSH NOTIFICATION WITH ABOVE MESSAGE
        $result_device = mysql_query("SELECT * FROM calendar_devices WHERE event_id = '$event_id' AND user = '$user'");
	while($device = mysql_fetch_assoc($result_device)){
		sendPushNotification($send_message,$device['reg_id']);
	}
        //UPDATE RECORD SO MULTIPLE NOTIFICATIONS AREN'T SENT
        $query = mysql_query("UPDATE calendars SET 3day = 'no' WHERE id = '$cal_id'");
    }
    
        

    if ($row['24hr'] == 'yes' && $row['3day'] == 'no' && (($row['starttstamp'] - $currenttime) >= $sec_24hr) && (($row['starttstamp'] - $currenttime) <= ($sec_24hr + 3600))) {
//SEND 24 HR NOTIFICATION
        echo '24hr = yes' . $row['email'] . $event_id;
        //SEND NOTIFICATION EMAIL
        if ($row['email']) {
            mail($row['email'], $send_message, $send_message, $headers);
        }
        //SEND NOTIFICATION TEXT MESSAGE
        if ($mobile_notif != '') {
            mail("$mobile_notif", "", $send_message, "From: Lobo Events <notifications@unmevents.com>\r\n");
        }
        //SEND PUSH NOTIFICATION WITH ABOVE MESSAGE
        $result_device = mysql_query("SELECT * FROM calendar_devices WHERE event_id = '$event_id' AND user = '$user'");
	while($device = mysql_fetch_assoc($result_device)){
		sendPushNotification($send_message,$device['reg_id']);
	}
        //UPDATE RECORD SO MULTIPLE NOTIFICATIONS AREN'T SENT
        $query = mysql_query("UPDATE calendars SET 24hr = 'no' WHERE id = '$cal_id'");
    }
    
        

    if ($row['3hr'] == 'yes' && $row['24hr'] == 'no' && (($row['starttstamp'] - $currenttime) >= 9000) && (($row['starttstamp'] - $currenttime) <= 12600)) {
//SEND 3 HR NOTIFICATION
        echo '3hr = yes' . $row['email'] . $event_id;
        //SEND NOTIFICATION EMAIL
        if ($row['email']) {
            mail($row['email'], $send_message, $send_message, $headers);
        }
        //SEND NOTIFICATION TEXT MESSAGE
        if ($mobile_notif != '') {
            mail("$mobile_notif", "", $send_message, "From: Lobo Events <notifications@unmevents.com>\r\n");
        }
        //SEND PUSH NOTIFICATION WITH ABOVE MESSAGE
        $result_device = mysql_query("SELECT * FROM calendar_devices WHERE event_id = '$event_id' AND user = '$user'");
	while($device = mysql_fetch_assoc($result_device)){
		sendPushNotification($send_message,$device['reg_id']);
	}
        //UPDATE RECORD SO MULTIPLE NOTIFICATIONS AREN'T SENT
        $query = mysql_query("UPDATE calendars SET 3hr = 'no' WHERE id = '$cal_id'");
    }
    
    /*echo '3hr: ' . $row['3hr'] . '<br>';
        echo 'starttstamp: ' . $row['starttstamp'] . '<br>';
        echo 'currenttime: ' . $currenttime . '<br>';
        echo 'sec_3hr: ' . $sec_3hr . '<br>';
        echo 'sec_3hr + 1800: ' . ($sec_3hr + 1800) . '<br>';
        echo 'starttstamp-currenttime: ' . ($row['starttstamp'] - $currenttime) . '<br>';
        echo '3hr = yes, starttstamp-currenttime >= sec_3hr, starttstamp-currenttime <= sec_3hr + 1800<br>';
        */

    if ($row['1hr'] == 'yes' && $row['3hr'] == 'no' && (($row['starttstamp'] - $currenttime) <= $sec_1hr)) {
//SEND 1 HR NOTIFICATION
        echo '1hr = yes' . $row['email'] . $event_id;
        //SEND NOTIFICATION EMAIL
        if ($row['email']) {
            mail($row['email'], $send_message, $send_message, $headers);
        }
        //SEND NOTIFICATION TEXT MESSAGE
        if ($mobile_notif != '') {
            mail("$mobile_notif", "", $send_message, "From: Lobo Events <notifications@unmevents.com>\r\n", $headers);
        }
        //SEND PUSH NOTIFICATION WITH ABOVE MESSAGE
        $result_device = mysql_query("SELECT * FROM calendar_devices WHERE event_id = '$event_id' AND user = '$user'");
	while($device = mysql_fetch_assoc($result_device)){
		sendPushNotification($send_message,$device['reg_id']);
	}
        //UPDATE RECORD SO MULTIPLE NOTIFICATIONS AREN'T SENT
        $query = mysql_query("UPDATE calendars SET 1hr = 'no' WHERE id = '$cal_id'");
    }
    echo '<hr>';
}

function sendPushNotification($mess,$reg_id) {
    $regId = array();
    $regId[0] = $reg_id;
    /*$i = 0;
    $result = mysql_query("select * FROM gcm");

    while ($row = mysql_fetch_array($result)) {
        $regId[$i] = $row['reg_id'];
        $i++;
    }*/

    include_once './gcm.php';
    $gcm = new GCM();
    $registration_ids = $regId;
    $message = array("price" => $mess);
    $response = $gcm->send_notification($registration_ids, $message);
    echo $response;
}

?>