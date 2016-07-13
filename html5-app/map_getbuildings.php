<?php
include('connect.php');
	
$url="http://datastore.unm.edu/locations/abqbuildings.xml";

$locations = simplexml_load_file($url);

$buildingsarray = array();
$display_locs;

foreach ($locations as $loc) {
		//Check if the "title" attribute matches $event['location']
		$loc_title = $loc['title'];
		$loc_long = $loc['longitude'];
		$loc_lat = $loc['latitude'];
		$loc_desc = $loc->description;
		$loc_img = $loc['image'];
		
		$loc_title = str_replace('/', '', $loc_title);
		$loc_title = str_replace("'", '&apos;', $loc_title);
		
		$loc_desc = str_replace('/', '', $loc_desc);
		$loc_desc = str_replace("'", '&apos;', $loc_desc);
		$loc_desc = str_replace("\n", '', $loc_desc);
		
		//if($loc_img != '')$loc_img_enter = "<br><img src=\"$loc_img\" width=\"180\">";
		//else $loc_img_enter = '';
		$loc_img_enter = '';
		
	$display_locs .= " ['<div style=\"width:200px;\"><strong>$loc_title</strong><br>$loc_desc$loc_img_enter</div>',$loc_lat,$loc_long,1], ";
}




$url="http://datastore.unm.edu/locations/gyms.xml";

$locations = simplexml_load_file($url);

$buildingsarray = array();
$display_locs;

foreach ($locations as $loc) {
		//Check if the "title" attribute matches $event['location']
		$loc_title = $loc['title'];
		$loc_long = $loc['longitude'];
		$loc_lat = $loc['latitude'];
		$loc_desc = $loc->description;
		$loc_img = $loc['image'];
		
		$loc_title = str_replace('/', '', $loc_title);
		$loc_title = str_replace("'", '&apos;', $loc_title);
		
		$loc_desc = str_replace('/', '', $loc_desc);
		$loc_desc = str_replace("'", '&apos;', $loc_desc);
		$loc_desc = str_replace("\n", '', $loc_desc);
		
		//if($loc_img != '')$loc_img_enter = "<br><img src=\"$loc_img\" width=\"180\">";
		//else $loc_img_enter = '';
		$loc_img_enter = '';
		
	$display_locs .= " ['<div style=\"width:200px;\"><strong>$loc_title</strong><br>$loc_desc$loc_img_enter</div>',$loc_lat,$loc_long,1], ";
}



$url="http://datastore.unm.edu/locations/libraries.xml";

$locations = simplexml_load_file($url);

$buildingsarray = array();
$display_locs;

foreach ($locations as $loc) {
		//Check if the "title" attribute matches $event['location']
		$loc_title = $loc['title'];
		$loc_long = $loc['longitude'];
		$loc_lat = $loc['latitude'];
		$loc_desc = $loc->description;
		$loc_img = $loc['image'];
		
		$loc_title = str_replace('/', '', $loc_title);
		$loc_title = str_replace("'", '&apos;', $loc_title);
		
		$loc_desc = str_replace('/', '', $loc_desc);
		$loc_desc = str_replace("'", '&apos;', $loc_desc);
		$loc_desc = str_replace("\n", '', $loc_desc);
		
		//if($loc_img != '')$loc_img_enter = "<br><img src=\"$loc_img\" width=\"180\">";
		//else $loc_img_enter = '';
		$loc_img_enter = '';
		
	$display_locs .= " ['<div style=\"width:200px;\"><strong>$loc_title</strong><br>$loc_desc$loc_img_enter</div>',$loc_lat,$loc_long,1], ";
}





$url="http://datastore.unm.edu/locations/dining.xml";

$locations = simplexml_load_file($url);

$buildingsarray = array();
$display_locs;

foreach ($locations as $loc) {
		//Check if the "title" attribute matches $event['location']
		$loc_title = $loc['title'];
		$loc_long = $loc['longitude'];
		$loc_lat = $loc['latitude'];
		$loc_desc = $loc->description;
		$loc_img = $loc['image'];
		
		$loc_title = str_replace('/', '', $loc_title);
		$loc_title = str_replace("'", '&apos;', $loc_title);
		
		$loc_desc = str_replace('/', '', $loc_desc);
		$loc_desc = str_replace("'", '&apos;', $loc_desc);
		$loc_desc = str_replace("\n", '', $loc_desc);
		
		//if($loc_img != '')$loc_img_enter = "<br><img src=\"$loc_img\" width=\"180\">";
		//else $loc_img_enter = '';
		$loc_img_enter = '';
		
	$display_locs .= " ['<div style=\"width:200px;\"><strong>$loc_title</strong><br>$loc_desc$loc_img_enter</div>',$loc_lat,$loc_long,1], ";
}





$url="http://datastore.unm.edu/locations/placesofinterest.xml";

$locations = simplexml_load_file($url);

$buildingsarray = array();
$display_locs;

foreach ($locations as $loc) {
		//Check if the "title" attribute matches $event['location']
		$loc_title = $loc['title'];
		$loc_long = $loc['longitude'];
		$loc_lat = $loc['latitude'];
		$loc_desc = $loc->description;
		$loc_img = $loc['image'];
		
		$loc_title = str_replace('/', '', $loc_title);
		$loc_title = str_replace("'", '&apos;', $loc_title);
		
		$loc_desc = str_replace('/', '', $loc_desc);
		$loc_desc = str_replace("'", '&apos;', $loc_desc);
		$loc_desc = str_replace("\n", '', $loc_desc);
		
		//if($loc_img != '')$loc_img_enter = "<br><img src=\"$loc_img\" width=\"180\">";
		//else $loc_img_enter = '';
		$loc_img_enter = '';
		
	$display_locs .= " ['<div style=\"width:200px;\"><strong>$loc_title</strong><br>$loc_desc$loc_img_enter</div>',$loc_lat,$loc_long,1], ";
}


$display_locs = substr($display_locs, 0, -1);
echo $display_locs;
?>