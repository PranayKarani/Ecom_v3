/**
 * Created by PranayKarani on 20/06/2016.
 */
var map;
var precision = 10;
$(document).ready(function() {

    $(".shop_box_top_open").mouseover(function() {

        var loc_x = $(this).find('#loc_x').val();
        var loc_y = $(this).find('#loc_y').val();
        var name = $(this).find('.shop_name').text();

        loc_x = roundFix(loc_x, precision);
        loc_y = roundFix(loc_y, precision);

        var myLatLng = {lat: loc_x, lng: loc_y};
        map.panTo(myLatLng);
        //shopSelect($(this));

    });

    $(".shop_box_top_right_open").click(function() {
        var id = $(this).attr("data-id");
        openShopPage(id, null);
    });

    $(".tabs").click(function() {

        var id = $(this).attr('id');

        switch (id) {
            case 'specs_tab':

                $("#specs_tab_content").fadeIn();
                $("#desc_tab_content").hide();

                break;
            case 'description_tab':
                $("#desc_tab_content").fadeIn();
                $("#specs_tab_content").hide();
                break;
        }

    });


    $(".thumbnail").click(function() {
        var src = $(this).attr("src");
        $("#product_image").attr("src", src);
    });

});

window.initMap = function() {

    var first_shop_open = $(".shop_box_open:first");
    var first_shop_close = $(".shop_box_close:first");

    var lat = first_shop_open.find("#loc_x").val();
    if (lat == null) {
        lat = first_shop_close.find("#loc_x").val();
    }

    var lng = first_shop_open.find("#loc_y").val();
    if (lng == null) {
        lng = first_shop_close.find("#loc_y").val();
    }
    lat = roundFix(lat, precision);
    lng = roundFix(lng, precision);

    var dService = new google.maps.DirectionsService;// to calculate directions

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
    var dDisplay = new google.maps.DirectionsRenderer({
        draggable: true,
        map: map
    });
    dDisplay.setMap(map);

    var infoWindow = new google.maps.InfoWindow();
    var openImage = {
        url: "res/images/extra/open.png"
    };
    var closeImage = {
        url: "res/images/extra/close.png"
    };

    $(".shop_box_open").each(function() {
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
            icon: openImage
        });

        marker.addListener('click', function() {
            map.panTo(myLatLng);
            shopSelect(this_box);
            infoWindow.setContent(name);
            infoWindow.open(map, marker);


        });

    });

    $(".walkIn").click(function() {
        var x = $(this);

        var loc_x = x.parent().parent().find('#loc_x').val();
        var loc_y = x.parent().parent().find('#loc_y').val();
        loc_x = roundFix(loc_x, precision);
        loc_y = roundFix(loc_y, precision);
        var dest = {lat: loc_x, lng: loc_y};
        var drive = $("#drive").is(":checked");
        calculateDirection(dService, dDisplay, dest, drive, infoWindow);

        var uid = x.attr("data-uid");
        var sid = x.attr("data-sid");
        var pid = x.attr("data-pid");
        var price = x.attr("data-price");

        var json = getJsonString(
            {
                uid: uid,
                sid: sid,
                pid: pid,
                price: price
            }
        );
        postStatic("controllers", "UserController", "recordRouteSelection", json, function(data) {

            console.info(data);

        });

    });

    $(".order").click(function() {
        console.info(loggedIn);
        if (loggedIn) {
            alert("Coming soon :)");
        } else {
            $("#login_modal").slideDown();
        }
    });

    var closeMarkers = [];
    $(".shop_box_close").each(function() {
        var this_box = $(this);
        var loc_x = $(this).find('#loc_x').val();
        var loc_y = $(this).find('#loc_y').val();
        var name = $(this).find('.shop_name').text();

        loc_x = roundFix(loc_x, precision);
        loc_y = roundFix(loc_y, precision);

        var myLatLng = {lat: loc_x, lng: loc_y};

        var marker = new google.maps.Marker({
            position: myLatLng,
            icon: closeImage
        });

        marker.addListener('click', function() {
            map.panTo(myLatLng);
            shopSelect(this_box);
            infoWindow.setContent(name);
            infoWindow.open(map, marker);


        });

        closeMarkers.push(marker);

    });

    $("#show_close").click(function() {
        var checked = $(this).is(":checked");

        if (checked) {

            for (var i = 0; i < closeMarkers.length; i++) {
                closeMarkers[i].setMap(map);
            }

        } else {
            for (var i = 0; i < closeMarkers.length; i++) {
                closeMarkers[i].setMap(null);
            }
        }
    });

};

function shopSelect(box) {
    var name = box.find('.shop_name').text();
    var id = box.attr("id");
    console.info(name + ' selected ' + box.offset().top);
    $('#top_left_bottom_right').animate(
        {
            scrollTop: box.offset().top - 300
        }, 500
    );
    box.animate(
        {
            outlineWidth: '10px',
            outlineColor: 'red'
        }, 300
    ).delay(100).animate(
        {
            outlineWidth: '0px',
            outlineColor: '#f37736'
        }, 600
    )
}

function calculateDirection(dService, dDisplay, dest, drive, infoWindow) {
    dService.route({
        origin: {lat: 19.176889, lng: 72.955271},
        destination: dest,
        travelMode: drive ? google.maps.TravelMode.DRIVING : google.maps.TravelMode.WALKING,
        provideRouteAlternatives: false
        //UnitSystem: UnitSystem.METRIC
    }, function(response, status) {
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

            var km = roundFix(distance / 1000, 2);

            var distance_string = "<strong>" + km + "</strong> km";
            var time_string = min == 1 ? "<strong>" + min + "</strong> min" : "<strong>" + min + "</strong> mins";

            infoWindow.setContent(distance_string + " (" + time_string + ")");
            infoWindow.setPosition(dest);
            infoWindow.open(map);

            console.info("noof of routes: " + noofRoutes);
            console.info("noof of legs: " + noofLegs);

        } else {
            alert('Directions request failed due to ' + status);
        }
    });
}

function addToCart(shopID, pID, price) {

    var arr = [];
    arr.push({shopID: shopID});
    arr.push({pID: pID});
    arr.push({price: price});

    var json = JSON.stringify(arr);

    postStatic("controllers", "UserController", "addToCart", json, function(data) {
        data = parseInt(data);
        if (data == -1) {
            $("#login_modal").slideDown();
        } else {
            if (data > 0) {
                $("#header_cart_button").text("Cart: " + data);
            } else {
                $("#header_cart_button").text("Cart");
            }
        }
    });

}