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

    var dService = new google.maps.DirectionsService;
    var dDisplay = new google.maps.DirectionsRenderer;
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
            title: name,
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
        calculateDirection(dService, dDisplay, dest);
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
function calculateDirection(dService, dDisplay, dest) {
    dService.route({
        origin: {lat: 19.176889, lng: 72.955271},
        destination: dest,
        travelMode: google.maps.TravelMode.WALKING
    }, function (response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            dDisplay.setDirections(response);
        } else {
            alert('Directions request failed due to ' + status);
        }
    });
}