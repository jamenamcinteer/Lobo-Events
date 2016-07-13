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
    EVENT DESCRIPTION &#9660;</span>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="min-width:250px;right:40%;">
    <li role="presentation"><a role="menuitem" tabindex="-1" href="event.php?id=<?php echo $eventid;?>">Event Description</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="home_map.php?id=<?php echo $eventid;?>">Event Location</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="add.php?id=<?php echo $eventid;?>">Add to Calendar</a></li>
  </ul>
</div>
<div id="dropdown-wide">
<h2>EVENT DESCRIPTION</h2>
&#9660;
  <ul>
    <li><a href="event.php?id=<?php echo $eventid;?>">Event Description</a></li>
    <li><a href="home_map.php?id=<?php echo $eventid;?>">Event Location</a></li>
    <li><a href="add.php?id=<?php echo $eventid;?>">Add to Calendar</a></li>
    <?php if($user){?><li><a href="settings.php"><br>My Settings</a></li><?php }?>
  </ul>
</div>

</div><!-- #nav_top -->

<div id="content" style="margin-top:45px;margin-bottom:120px;">

<?php
if(isset($_POST['submitAdmin'])){
	$starttstamp = $_POST['starttstamp'];
	$building_latlng = $_POST['building_latlng'];
	$loc_info = $_POST['loc_info'];
	$latlng = $_POST['latlng'];
	
	if($building_latlng){
	$latlngs = explode(",", $building_latlng);
	$lat = $latlngs[0];
	$long = $latlngs[1];
	}
	if(!$building_latlng){
	$latlngs = explode(",", $latlng);
	$lat = $latlngs[0];
	$long = $latlngs[1];
	}
	//$eventid;
	/*echo $eventid;
	echo $starttstamp;
	echo $lat;
	echo $long;
	echo $loc_info;*/
	$insert = mysql_query("INSERT INTO map_events (event_id, starttstamp, lat, `long`, location_name) VALUES ('$eventid','$starttstamp','$lat','$long','$loc_info')");
	//echo mysql_error();
	echo 'Done.';
}
?>

<?php
$url="http://datastore.unm.edu/events/events.xml";

$events = simplexml_load_file($url);

//echo $events->vcalendar->components->vevent[0]->properties->categories->text;

$eventsarray = array();

foreach ($events->vcalendar->components->vevent as $event) {
	$description = str_replace('\n','<br>',$event->properties->description->text);
	
	$current_date = time();
	
	$starttstamp = strtotime($event->properties->dtstart->{'date-time'});
	if($starttstamp == 0 || $starttstamp == '')$starttstamp = strtotime($event->properties->dtstart->{'date'});
	
	$endtstamp = strtotime($event->properties->dtend->{'date-time'});
	if($endtstamp == 0 || $endtstamp == '')$endtstamp = strtotime($event->properties->dtend->{'date'});
	
	$startdate = date("D, M j, Y g:i a",$starttstamp);
	
	$enddate = date("D, F j, Y g:i a",$endtstamp);
	
	$maxchars = 300;
	$content = substr($description, 0, $maxchars);
	$content = $content . '...';
	
	$summary = $event->properties->summary->text;
	$image = $event->properties->attach->uri;
	$category = $event->properties->categories->text;
	$location = $event->properties->location->text;
	$id = $event->properties->uid->text;
	
	if($id == $eventid){
	array_push($eventsarray, array('startdate' => $startdate, 'enddate' => $enddate, 'description' => $description, 'summary' => $summary, 'image' => $image, 'starttstamp' => $starttstamp, 'category' => $category, 'location' => $location, 'id' => $id));}
   }
   
   
foreach ($eventsarray as $event) {
	
	//echo'<style type="text/css">body {background-image:url("'.$event['image'].'");}</style>';
	echo '<div class="event" style="padding:20px;">';
	
	echo '<h2>' . $event['summary'] . '</h2>';
	//echo '<a href="add.php?id=' . $event['id'] . '"><img src="img/plus.png"></a><img src="img/geotag.png"><img src="img/facebook 1.png"><img src="img/twitter 1.png">';
	
	echo '<p style="text-align:center;margin-left:-5px;"><br>';
	//echo $event['starttstamp'] . '<br>';
	
	$curevent_id = $event['id'];
	//if(!$reg_id){$result = mysql_query("SELECT id FROM calendars WHERE cookie_id = '$cookie_id' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");}
	if($reg_id){$result = mysql_query("SELECT id FROM calendars WHERE reg_id = '$reg_id' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");}
	if($user != 'NONE'){$result = mysql_query("SELECT id FROM calendars WHERE user = '$user' AND event_id = '$curevent_id' ORDER BY id ASC LIMIT 1");
	$row = mysql_fetch_row($result);
	if($row[0] != ''){echo '<img src="img/button_add_done.png" alt="Added to Calendar">';}
	if($row[0] == ''){echo '<a href="add.php?id=' . $event['id'] . '"><img src="img/button_add.png" alt="Add to Calendar" style="border:1px solid #939598;margin:7px;"></a>';}
	}
	if($user == 'NONE'){echo '<div class="list_event_add"><a href="add.php?id=' . $event['id'] . '"><img src="img/button_add.png" alt="Add to Calendar"></a></div>';}
	
	echo'
	<a href="https://www.facebook.com/sharer/sharer.php?u=http://unmevents.com/event.php?id=' . $event['id'] . '"><img src="img/button_fb.png" alt="Share to Facebook" style="border:1px solid #939598;margin:7px;"></a>
	<a href="http://twitter.com/share?text=' . $event['summary'] . '&url=http://unmevents.com/event.php?id=' . $event['id'] . '"><img src="img/button_twitter.png" style="border:1px solid #939598;margin:7px;" alt="Share to Twitter"></a><br></p>';
	
	echo '<h3>When</h3>';
	if($event['startdate'] != $event['enddate'] && $event['enddate'] != 'Wed, Dec 31, 1969 5:00 pm')echo '<p style="margin-left:10px;margin-bottom:15px;font-weight:bold;color:gray;font-family:Muli,Verdana,sans-serif;">' . $event['startdate'] . ' - ' . $event['enddate'];
	else echo '<p style="margin-left:10px;margin-bottom:15px;font-weight:bold;color:gray;font-family:Muli,Verdana,sans-serif;">' . $event['startdate'];
	echo '</p>';
	echo '<h3>Where</h3>';
	echo"<p style='margin-bottom:15px;font-family:Muli,Verdana,sans-serif;'><strong style='color:gray;margin-left:10px;'>" . $event['location'] . "</strong></p>";
	echo '<h3>Description</h3><div style="margin-left:10px;margin-bottom:15px;color:gray;font-family:Muli,Verdana,sans-serif;">';
	
	if($event['image'] != ''){echo '<img src="' . $event['image'] . '" class="event_img" alt="Event Image">';}
	
	$replace_array1 = array(
	'StudentsFacultyStaffAlumniParentsProspectives (students/parents)Public',
	'StudentsFacultyStaffAlumniPublic',
	'StudentsFacultyAlumniProspectives (students/parents)Public',
	'StudentsParentsProspectives (students/parents)Public',
	'StudentsFacultyStaffPublic',
	'StudentsFacultyAlumniPublic',
	'StudentsFacultyStaffAlumni',
	'StudentsFacultyStaff',
	'StudentsFacultyPublic',
	'StudentsStaffPublic',
	'StudentsFaculty',
	'FacultyStaff',
	'FacultyPublic',
	'Event Description',
	'Audience',
	'Contact Information',
	'Location Information',
	'Location Details'
	);
	$replace_array2 = array(
	'<ul><li>Students</li><li>Faculty</li><li>Staff</li><li>Alumni</li><li>Parents</li><li>Prospectives (students/parents)</li><li>Public</li></ul>',
	'<ul><li>Students</li><li>Faculty</li><li>Staff</li><li>Alumni</li><li>Public</li></ul>',
	'<ul><li>Students</li><li>Faculty</li><li>Alumni</li><li>Prospectives (students/parents)</li><li>Public</li></ul>',
	'<ul><li>Students</li><li>Parents</li><li>Prospectives (students/parents)</li><li>Public</li></ul>',
	'<ul><li>Students</li><li>Faculty</li><li>Staff</li><li>Public</li></ul>',
	'<ul><li>Students</li><li>Faculty</li><li>Alumni</li><li>Public</li></ul>',
	'<ul><li>Students</li><li>Faculty</li><li>Staff</li><li>Alumni</li></ul>',
	'<ul><li>Students</li><li>Faculty</li><li>Staff</li></ul>',
	'<ul><li>Students</li><li>Faculty</li><li>Public</li></ul>',
	'<ul><li>Students</li><li>Staff</li><li>Public</li></ul>',
	'<ul><li>Students</li><li>Faculty</li></ul>',
	'<ul><li>Faculty</li><li>Staff</li></ul>',
	'<ul><li>Faculty</li><li>Public</li></ul>',
	'<strong>Event Description</strong>',
	'<strong>Audience</strong>',
	'<strong>Contact Information</strong>',
	'<strong>Location Information</strong>',
	'<strong>Location Details</strong>'
	);
	
	$event['description'] = str_replace($replace_array1,$replace_array2,$event['description']);
	
	//$event['description'] = str_replace('\n','<br>',$event['description']);
	echo  $event['description'];
	echo '<br><a href="home_map.php?id=' . $event['id'] . '">View Map</a></div>';
	echo"<br><em style='font-family:Muli,Verdana,sans-serif;'>" . $event['category'] . "</em>";
	
	//ADMIN
	if($user == 'ndjamenamarmon@gmail.com'){
	echo '
	<form method="post">
	<input type="hidden" name="starttstamp" value="' . $event['starttstamp'] . '">
	<select name="building_latlng">
	<option value="">Campus building...</option>';
	include('geolobo_getbuildings.php');
	echo'</select> 
	<input type="text" name="loc_info" placeholder="Location Info"> 
	<input type="text" name="latlng" placeholder="Latitude,Longitude (if no building selected)"> 
	<input type="submit" name="submitAdmin" value="Submit Location">
	</form>
	';
	}
	
	echo '</div>';
	
	
	

	//IF THERE ARE MULTIPLE LOCATIONS, CREATE AN ARRAY WITH EACH LOCATION'S INFO
	//Search if location is in the crossref
	$url_loc="http://datastore.unm.edu/events/event_location_xref.csv";
	$locations = file($url_loc, FILE_IGNORE_NEW_LINES);
	
	$file = '';	
	foreach($locations as $location){
		//not getting it line by line	
		$location_name = str_replace('/', '', $location[0]);
		if (preg_match("/$location_name/i", $event['location'])) {
		    //If found, get file name for building location from other repository
		    $file = $location[1] . '.xml';
		}
	}	
	
	$file = 'abqbuildings.xml';
	//Search for building data in location repository, especially lat/lng data
	$file = 'http://datastore.unm.edu/locations/' . $file;
	$locationsB = simplexml_load_file($file);
	
	foreach ($locationsB as $loc) {
		//Check if the "title" attribute matches $event['location']
		$event_loc = $event['location'];
		$data_loc = $loc['title'];
		
		$data_loc = str_replace('/', '', $data_loc);
		if(preg_match("/$data_loc/i", $event_loc)){
		
?>		
    <!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>    
        <script type="text/javascript">

function initialize() {
  var myLatlng = new google.maps.LatLng(<?php echo $loc['latitude'];?>,<?php echo $loc['longitude'];?>);
  var mapOptions = {
    zoom: 18,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  
  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading"><?php echo $event['summary'];?></h1>'+
      '<div id="bodyContent">'+
      '<p><?php echo $event['location'];?></p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });
  
    google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
    </script>-->

			
<?php		
		}
	}

   }
?>

<!--<div id="fb-root"></div>-->
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<fb:comments width="450" mobile="true" href="http://unmevents.com/app/event.php?id=<?php echo $eventid;?>"></fb:comments>

<div id="map-canvas"></div>

</div>

<?php }?>
<?php include('footer.php');?>