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
        map.panTo(myLatLng, 3000);
        shopSelect(name);

    });

});


function initMap(loc_x, loc_y) {
    var mapDiv = document.getElementById('top_left_bottom_left');
    map = new google.maps.Map(mapDiv, {
        center: {lat: 19.182469, lng: 72.95412},
        zoom: 18,
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
            title: name
        });

        marker.addListener('click', function () {
            map.setCenter(myLatLng);
            shopSelect(name);
        });


    });

}
function roundFix(number, precision) {
    var multi = Math.pow(10, precision);
    return Math.round((number * multi).toFixed(precision + 1)) / multi;
}

function shopSelect(name) {
    console.info(name + ' selected');
}