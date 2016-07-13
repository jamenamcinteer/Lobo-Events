<!DOCTYPE html>
<html>
  <head>
    <title>Custom Street View panoramas</title>
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
function initialize() {
  // Set up Street View and initially set it visible. Register the
  // custom panorama provider function. Set the StreetView to display
  // the custom panorama 'reception' which we check for below.
  var panoOptions = {
    pano: 'reception',
    visible: true,
    panoProvider: getCustomPanorama
  };

  var panorama = new google.maps.StreetViewPanorama(
    document.getElementById('map-canvas'), panoOptions);
}

// Return a pano image given the panoID.
function getCustomPanoramaTileUrl(pano, zoom, tileX, tileY) {
  // Note: robust custom panorama methods would require tiled pano data.
  // Here we're just using a single tile, set to the tile size and equal
  // to the pano "world" size.
  return 'http://www.carto.net/neumann/panoramas/sandnes_flakstadoya_lofoten_2008_06/pano1/sandnes_flakstadoya_lofoten_panorama_medium_res.jpg';
}

// Construct the appropriate StreetViewPanoramaData given
// the passed pano IDs.
function getCustomPanorama(pano, zoom, tileX, tileY) {
  if (pano == 'reception') {
    return {
      location: {
        pano: 'reception',
        description: 'Google Sydney - Reception'
      },
      links: [],
      // The text for the copyright control.
      copyright: 'Imagery (c) 2010 Google',
      // The definition of the tiles for this panorama.
      tiles: {
        tileSize: new google.maps.Size(1024, 512),
        worldSize: new google.maps.Size(1024, 512),
        // The heading in degrees at the origin of the panorama
        // tile set.
        centerHeading: 105,
        getTileUrl: getCustomPanoramaTileUrl
      }
    };
  }
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>