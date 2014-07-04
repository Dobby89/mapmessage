var infowindow = null;

if (navigator.geolocation) {
  var timeoutVal = 10 * 1000 * 1000;
  navigator.geolocation.getCurrentPosition(
    currentPosition,
    geolocationError,
    { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
  );
}
else {
  alert("Geolocation is not supported by this browser");
}

function currentPosition(position) {

  renderGoogleMap(position.coords.latitude, position.coords.longitude);
}

function geolocationError(error) {

  // HTML5 geolocation error codes
  var errors = {
    1: 'Permission denied',
    2: 'Position unavailable',
    3: 'Request timeout'
  };

  alert("Error: " + errors[error.code]);
}






function renderGoogleMap(lat, lng) {

  var infowindow = null;
  var mapContainer = $('#google-map-map');

  var centerMap = new google.maps.LatLng(lat, lng);

  var myOptions = {
    zoom: 4,
    center: centerMap,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }

  var map = new google.maps.Map(mapContainer.get(0), myOptions);

  setMarkers(map, sites);
  infowindow = new google.maps.InfoWindow({
    content: "loading..."
  });

  var bikeLayer = new google.maps.BicyclingLayer();
  bikeLayer.setMap(map);
}

var sites = [
  ['Mount Evans', 39.58108, -105.63535, 4, 'This is Mount Evans.'],
  ['Irving Homestead', 40.315939, -105.440630, 2, 'This is the Irving Homestead.'],
  ['Badlands National Park', 43.785890, -101.90175, 1, 'This is Badlands National Park'],
  ['Flatirons in the Spring', 39.99948, -105.28370, 3, 'These are the Flatirons in the spring.']
];



function setMarkers(map, markers) {

  for (var i = 0; i < markers.length; i++) {
    var sites = markers[i];
    var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
    var marker = new google.maps.Marker({
      position: siteLatLng,
      map: map,
      title: sites[0],
      zIndex: sites[3],
      html: sites[4]
    });

    var contentString = "Some content";

    google.maps.event.addListener(marker, "click", function () {
      alert(this.html);
      infowindow.setContent(this.html);
      infowindow.open(map, this);
    });
  }
}



//function renderGoogleMap(location) {
//
//  // set up google map centered on the user's current location
//  var map;
//  var gmap = google.maps;
//  var mapContainer = $('#google-map-map');
//  var googleLatlng = new gmap.LatLng(location[0].lat, location[0].lon);
//  console.log(googleLatlng);
//  var mapOptions = {
//    zoom: 10,
//    center: new gmap.LatLng(googleLatlng)
//  };
//  var bounds = new gmap.LatLngBounds();
//  var markers = [];
//  infowindow = new google.maps.InfoWindow({
//    content: "Loading..."
//  });
//  var currentLocationMarkerImage = {
//    url: 'dist/ui/map/marker-purple.png',
//    size: new gmap.Size(64, 64),
//    origin: new gmap.Point(0, 0),
//    anchor: new gmap.Point(19, 48)
//  };
//  var markerImage = {
//    url: 'dist/ui/map/marker.png',
//    size: new gmap.Size(64, 64),
//    origin: new gmap.Point(0, 0),
//    anchor: new gmap.Point(19, 48)
//  };
//
//  // add the map to the html element
//  if (!map) {
//    map = new gmap.Map(mapContainer.get(0), mapOptions);
//  }
//
//  var geoencode = function(latLon) {
//    geocoder.geocode({'latLng': latLon}, function(results, status) {
//      if (status == google.maps.GeocoderStatus.OK) {
//        if (results[1]) {
//          return results[1].formatted_address;
//        } else {
//          return 'No results found';
//        }
//      } else {
//        return 'Geocoder failed due to: ' + status;
//      }
//    });
//  }
//
//
//  // add the current location to the map as a marker
//  var currentMarker = new gmap.Marker({
//    position: googleLatlng,
//    map: map,
//    title: 'Home',
//    icon: currentLocationMarkerImage,
//
//    labelContent: "A",
//    labelClass: "labels", // the CSS class for the label
//    labelInBackground: false
//  });
//  //markers.push(marker);
//
//  bounds.extend(googleLatlng);
//
//
//
//  // add thread markers to map
//  var threads = [
//    {
//      title: 'somewhere',
//      lat: 53.784022,
//      lon: -2.4245491
//    },
//    {
//      title: 'somewhere else',
//      lat: 53.794022,
//      lon: -2.4345491
//    },
//    {
//      title: 'somewhere else again',
//      lat: 53.804022,
//      lon: -2.4445491
//    }
//  ];
//
//  var markerClicked = function (marker, location) {
//    console.log(marker.title);
//    map.setCenter(marker.getPosition());
//  }
//
//  var getClickListener = function(marker, location) {
//    return function () {
//      markerClicked(marker, location);
//    };
//  };
//
//  for (var i = 0; i < threads.length; i++) {
//    var thread = threads[i];
//    var pos = new gmap.LatLng(thread.lat, thread.lon);
//    var marker = new gmap.Marker({
//      position: pos,
//      title: thread.title,
//      map: map,
//      icon: markerImage
//    });
//    bounds.extend(pos);
//    markers.push(marker);
//
//    location.marker = marker;
//    gmap.event.addListener(marker, 'click', getClickListener(marker, location));
//  }
//
//  //console.log(markers);
//
//  map.fitBounds(bounds);
//  map.setCenter(new gmap.LatLng(googleLatlng));
//}