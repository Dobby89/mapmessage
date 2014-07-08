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