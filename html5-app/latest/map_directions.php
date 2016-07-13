<!DOCTYPE html>
<html> 
<head> 
   <meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <title>GeoLobo</title> 
   <script type="text/javascript" 
           src="http://maps.google.com/maps/api/js?sensor=true"></script>
           <!--<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5TFNcax88HN78Ijl-580aMU7sf6Et0w8&libraries=panoramio&sensor=true">-->
           
           <style type="text/css">
           #map {width:100%;height:900px;}
           #panel {width:100%;}
           #panel_select {
           	position: absolute;
	        top: 30px;
	        right:10px;
	        /*margin-left: -180px;*/
	        z-index: 5;
	        background-color: #fff;
	        padding: 5px;
	        border: 1px solid #999;
	   }
	   #panel_select select {
	   max-width:120px;
	   }
	   #panel_mode_dir, #panel_mode_map, #panel_mode_update {
           	position: fixed;
	        bottom: 10px;
	        right:10px;
	        /*margin-left: -180px;*/
	        z-index: 5;
	        background-color: #fff;
	        padding: 5px;
	        border: 1px solid #999;
	   }
	   #panel_mode_map {right:79px;}
	   #panel_mode_update {right:114px;font-weight:bold;}
	   .panel_mode a:link, .panel_mode a:hover, .panel_mode a:link, .panel_mode a:visited {
	   font-weight:bold;
	   text-decoration:none;
	   color:black;
	   }
	   .panel_mode a:hover, .panel_mode a:active {
	   color:#CE0F42;
	   }
	   
           @media (min-width:600px) {
           #map {width: 60%; height: 700px; float: left;}
           #panel {width: 40%; float: right;}
           #panel_select {
           	right:40%;
           	margin-right:10px;
	   }
	   #panel_select select {
	   max-width:260px;
	   }
	   #panel_mode_dir, #panel_mode_map {display:none;}
	   #panel_mode_update {left:10px;right:auto;}
           }
           </style>
</head> 
<body style="font-family: Arial; font-size: 12px;margin:0;padding:0;"> 
   <div style="width: 100%;margin:0;padding:0;">
     <div id="map"></div> 
     <div id="panel"></div>
     <div id="panel_select">
     	    <select id="mode" onchange="calcRoute();">
     	      <option value="WALKING">Walking</option>
	      <option value="BICYCLING">Bicycyling</option>
	      <option value="DRIVING">Driving</option>
	      <option value="TRANSIT">Transit</option>
	    </select>
	      <select id="end" onchange="calcRoute();">
	      <option value='35.0839,-106.6186'>Select Campus Destination...</option>
	      <?php include('geolobo_getbuildings.php');?>
	    </select>
     </div>
     <div id="panel_mode_dir" class="panel_mode">
     	<a href="#panel">Directions</a>
     </div>
     <div id="panel_mode_map" class="panel_mode">
     	<a href="#map">Map</a>
     </div>
     <div id="panel_mode_update" class="panel_mode" onclick="calcRoute();">
 	Update My Location
     </div>
   </div>
   <script type="text/javascript">
var map;
function initialize() {	  
  var mapOptions = {
    zoom: 17,
    center: new google.maps.LatLng(35.0839, -106.6186)
  };
  map = new google.maps.Map(document.getElementById('map'),
      mapOptions);
      
      
           var styles = [
  {
    "featureType": "administrative",
    "elementType": "geometry",
    "stylers": [
      { "color": "#c2c2c2" }
    ]
  },{
    "featureType": "landscape.man_made",
    "elementType": "geometry",
    "stylers": [
      { "color": "#e2e2e2" }
    ]
  },{
  },{
    "featureType": "poi.school",
    "elementType": "geometry",
    "stylers": [
      { "color": "#ffffff" }
    ]
  },{
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      { "color": "#c8c9c9" }
    ]
  },{
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
      { "color": "#c8c8c8" }
    ]
  },{
    "featureType": "road.local",
    "elementType": "geometry",
    "stylers": [
      { "color": "#ebebec" }
    ]
  },{
    "featureType": "landscape.man_made",
    "stylers": [
      { "color": "#e2e2e2" }
    ]
  }
];
map.setOptions({styles: styles});


}

google.maps.event.addDomListener(window, 'load', calcRoute);

   
   function calcRoute() {
	  if (navigator.geolocation)
	    {
	    navigator.geolocation.getCurrentPosition(showPosition);
	    }
	function showPosition(position)
	  {
	  var latlon=position.coords.latitude+","+position.coords.longitude;


     var directionsService = new google.maps.DirectionsService();
     var directionsDisplay = new google.maps.DirectionsRenderer();
     
     var initialLocation;
     var browserSupportFlag =  new Boolean();

     var map = new google.maps.Map(document.getElementById('map'), {
       zoom:16,
       mapTypeId: google.maps.MapTypeId.ROADMAP
     });

     directionsDisplay.setMap(map);
     directionsDisplay.setPanel(document.getElementById('panel'));
     
     
     var styles = [
  {
    "featureType": "administrative",
    "elementType": "geometry",
    "stylers": [
      { "color": "#c2c2c2" }
    ]
  },{
    "featureType": "landscape.man_made",
    "elementType": "geometry",
    "stylers": [
      { "color": "#e2e2e2" }
    ]
  },{
  },{
    "featureType": "poi.school",
    "elementType": "geometry",
    "stylers": [
      { "color": "#ffffff" }
    ]
  },{
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      { "color": "#c8c9c9" }
    ]
  },{
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
      { "color": "#c8c8c8" }
    ]
  },{
    "featureType": "road.local",
    "elementType": "geometry",
    "stylers": [
      { "color": "#ebebec" }
    ]
  },{
    "featureType": "landscape.man_made",
    "stylers": [
      { "color": "#e2e2e2" }
    ]
  }
];
map.setOptions({styles: styles});

var end = document.getElementById('end').value;
var mode = document.getElementById('mode').value;
document.getElementById("panel").innerHTML = "";

     var request = {
       origin: latlon, 
       destination: end,
       travelMode: google.maps.TravelMode[mode]
     };

     directionsService.route(request, function(response, status) {
       if (status == google.maps.DirectionsStatus.OK) {
         directionsDisplay.setDirections(response);
       }
     });
     
     
     }
     


}
   </script> 
</body> 
</html>