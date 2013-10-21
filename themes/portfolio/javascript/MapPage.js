function initialize(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);

    var mapOptions = {
        center: latlng,
        zoom: 8
    };

    var map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);

    var marker = new google.maps.Marker({
        position: latlng,
        map: map
    });
}