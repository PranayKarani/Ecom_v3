/**
 * Created by PranayKarani on 20/06/2016.
 */
$(document).ready(function () {

});


function initMap(loc_x, loc_y) {
    var mapDiv = document.getElementById('top_left_bottom_left');
    var map = new google.maps.Map(mapDiv, {
        center: {lat: 44.540, lng: -78.546},
        zoom: 8
    });
}
