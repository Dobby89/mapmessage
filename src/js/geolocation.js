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

  var latitude = position.coords.latitude;
  var longitide = position.coords.longitude

  ajaxGetThreads(latitude, longitide);

  renderGoogleMap(latitude, longitide);
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

  var mapContainer = $('#google-map-map');
  var centerMap = new google.maps.LatLng(lat, lng);
  var myOptions = {
    zoom: 15,
    center: centerMap,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(mapContainer.get(0), myOptions);
}