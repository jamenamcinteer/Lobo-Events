    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100%;margin-top:45px; }
    </style>
    <!--<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5TFNcax88HN78Ijl-580aMU7sf6Et0w8&sensor=true">
    </script>-->
    <script type="text/javascript" 
           src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
    	  function geonavigator(){
    	  
    	  if (navigator.geolocation)
	    {
	    navigator.geolocation.getCurrentPosition(initialize);
	    }
	    
	  }
	  var map;
      function initialize(position) {
      //function initialize() {
      
      var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        var mapOptions = {
          center: userLatLng,
          zoom: 17
        };
        map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
            
            
		    layer = new google.maps.FusionTablesLayer({
		    map: map,
		      heatmap: { enabled: false },
		      query: {
		        select: "col2",
		        from: "1D-q4HG_SIojZFlgUnekeWcgTRMbkpmaN9SdYTc0",
		        where: ""
		      },
		      options: {
		        styleId: 2,
		        templateId: 2
		      },
		    styles: [{
			  markerOptions: {
			    iconName: "measle_grey"
			  }
			}]
		  });
		  layer.setMap(map);
	


  
            
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
  
 
        //var latlon=position.coords.latitude+","+position.coords.longitude;
        
       
  
  var locationsB = [
<?php include('map_getevents.php');?>
    ];
    

    
    
         var infowindowB = new google.maps.InfoWindow();
	 var markersBArray = [];
    var markerB, iB;
    var iconB = 'img/mapicon2.png';
    for (iB = 0; iB < locationsB.length; iB++) {  
      markerB = new google.maps.Marker({
        position: new google.maps.LatLng(locationsB[iB][1], locationsB[iB][2]),
        map: map,
        icon: locationsB[iB][3]
      });

      google.maps.event.addListener(markerB, 'click', (function(markerB, iB) {
        return function() {
          infowindowB.setContent(locationsB[iB][0]);
          infowindowB.open(map, markerB);
        }
      })(markerB, iB));
	  
	  markersBArray.push(markerB);
    }
    
    
    
    
      }
	  
	  /*function setMarkerVisible(map,markersArray) {
		var zoom = map.getZoom();
		for (i = 0; i < markersArray.length; i++) {
			markersArray[i].setVisible(zoom > 16);
		}
	}*/
	
	
	
	var markerHere;
function setPos(){
    	  
    	  if (navigator.geolocation)
	    {
	    navigator.geolocation.getCurrentPosition(startPos);
	    }
	  }
function updatePos(){
    	  
    	  if (navigator.geolocation)
	    {
	    //navigator.geolocation.watchPosition(curPos,errorMsg,{enableHighAccuracy: true});
	    navigator.geolocation.watchPosition(curPos,errorMsg);
	    //navigator.geolocation.getCurrentPosition(curPos);
	    }
	  }
	  function errorMsg(){alert('Enable GPS to access the map.');}
function startPos(position){	
//markersHere.setMap(null);
 var icon = 'img/mapicon5.png';
var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    markerHere = new google.maps.Marker({
        position: userLatLng,
        map: map,
        icon: icon
        });
    var userInfo = new google.maps.InfoWindow();
    google.maps.event.addListener(markerHere, 'click', (function(markerHere){
    	return function(){
    	userInfo.setContent('<div style="min-width:120px;"><strong>You are here</strong></div>');
    	userInfo.open(map, markerHere);
    	}
    })(markerHere));
     //markersHere.push(markerHere);
    }
    
function curPos(position){
    var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    markerHere.setPosition(userLatLng);
  
}
      
      google.maps.event.addDomListener(window, 'load', geonavigator);
      google.maps.event.addDomListener(window, 'load', setPos);
      google.maps.event.addDomListener(window, 'load', updatePos);
      var myVar=setInterval(function(){updatePos()},1000);
    </script>

<ul id="photo-panel" style="display:none;">
      <li><strong>Photos clicked</strong></li>
    </ul>
    <div id="map-canvas"></div>

<?php $nav_bottom_page = 'map';?>