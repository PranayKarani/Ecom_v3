/**
 * Created by PranayKarani on 20/06/2016.
 */
var map;
var precision = 10;
$(document).ready(function () {

    $(".shop_box").click(function () {

        var loc_x = $(this).find('#loc_x').val();
        var loc_y = $(this).find('#loc_y').val();
        var name = $(this).find('.shop_name').text();

        loc_x = roundFix(loc_x, precision);
        loc_y = roundFix(loc_y, precision);

        var myLatLng = {lat: loc_x, lng: loc_y};
        map.panTo(myLatLng);
        shopSelect($(this));

    });

});


function initMap() {

    var lat = $(".shop_box:first").find("#loc_x").val();
    var lng = $(".shop_box:first").find("#loc_y").val();
    lat = roundFix(lat, precision);
    lng = roundFix(lng, precision);

    var dService = new google.maps.DirectionsService;// to calculate directions
    var dDisplay = new google.maps.DirectionsRenderer({
        draggable: true,
        map: map,
    });

    var mapDiv = document.getElementById('top_left_bottom_left');
    map = new google.maps.Map(mapDiv, {
        center: {lat: lat, lng: lng},
        zoom: 15,
        zoomControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: false,
        rotateControl: true,
        fullscreenControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        }
    });
    dDisplay.setMap(map);

    var infoWindow = new google.maps.InfoWindow();

    $(".shop_box").each(function () {
        var this_box = $(this);
        var loc_x = $(this).find('#loc_x').val();
        var loc_y = $(this).find('#loc_y').val();
        var name = $(this).find('.shop_name').text();

        loc_x = roundFix(loc_x, precision);
        loc_y = roundFix(loc_y, precision);

        var myLatLng = {lat: loc_x, lng: loc_y};

        var marker = new google.maps.Marker({
            map: map,
            position: myLatLng,
            animation: google.maps.Animation.DROP
        });

        marker.addListener('click', function () {
            map.panTo(myLatLng);
            shopSelect(this_box);
            infoWindow.setContent(name);
            infoWindow.open(map, marker)
        });

    });

    $(".walkIn").click(function () {
        var loc_x = $(this).parent().parent().find('#loc_x').val();
        var loc_y = $(this).parent().parent().find('#loc_y').val();
        loc_x = roundFix(loc_x, precision);
        loc_y = roundFix(loc_y, precision);
        var dest = {lat: loc_x, lng: loc_y};
        var drive = $("#drive").is(":checked");
        calculateDirection(dService, dDisplay, dest, drive);
    });

}


function roundFix(number, precision) {
    var multi = Math.pow(10, precision);
    return Math.round((number * multi).toFixed(precision + 1)) / multi;
}

function shopSelect(box) {
    var name = box.find('.shop_name').text();
    //box.css("outline", "2px solid red");
    console.info(name + ' selected');
}
function calculateDirection(dService, dDisplay, dest, drive) {
    dService.route({
        origin: {lat: 19.176889, lng: 72.955271},
        destination: dest,
        travelMode: drive ? google.maps.TravelMode.DRIVING : google.maps.TravelMode.WALKING,
        provideRouteAlternatives: false
        //UnitSystem: UnitSystem.METRIC
    }, function (response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            dDisplay.setDirections(response);
            var routes = response.routes;
            var legs = [];
            var noofRoutes = routes.length;
            var noofLegs = 0;
            var distance = 0;
            var time = 0;

            for (var i = 0; i < noofRoutes; i++) {
                legs = routes[i].legs;
                noofLegs += legs.length;
                for (var j = 0; j < noofLegs; j++) {
                    console.info(legs[j]);
                    distance += legs[j].distance.value;
                    time += legs[j].duration.value;
                }
            }

            var min = roundFix(time / 60, 0);
            var sec = time % 60;

            console.info("noof of routes: " + noofRoutes);
            console.info("noof of legs: " + noofLegs);
            console.info("distance: " + distance + " meters");
            console.info("duration: " + min + "m " + sec + "s");
        } else {
            alert('Directions request failed due to ' + status);
        }
    });
}