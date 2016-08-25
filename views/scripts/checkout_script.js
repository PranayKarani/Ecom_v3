/**
 * Created by PranayKarani on 26/07/2016.
 */
var type;
var map;
var markers = [];
var precision = 3;

$(document).ready(function() {

    type = $("#type").val();
    loadProducts(type);

});

window.initMap = function() {

    var lat = 19.176785;
    var lng = 72.955225;

    lat = roundFix(lat, precision);
    lng = roundFix(lng, precision);

    var startLoc = {lat: lat, lng: lng};

    var mapDiv = document.getElementById('left_bottom');
    map = new google.maps.Map(mapDiv, {
        center: startLoc,
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

    // get locations and set markers
    postStatic("controllers", "UserController", "getCheckoutShopLocations", type, function(data) {
        var d = JSON.parse(data);
        console.info("data: " + data);
        console.info("d: " + d);

        for (var i = 0; i < d.length; i++) {

            var sID = d[i].shop_id;
            var x = d[i].loc_x;
            var y = d[i].loc_y;
            var name = d[i].shop_name;
            var open = d[i].open;
            x = roundFix(x, precision);
            y = roundFix(y, precision);
            var obj = {lat: x, lng: y};

            var shopMarkerImage;
            if (open == 1) {
                shopMarkerImage = openImage;
            } else {
                shopMarkerImage = closeImage;
            }

            var marker = new google.maps.Marker({
                map: map,
                position: obj,
                icon: shopMarkerImage,
                title: name
            });

            function setMarkerContent(obj, name, marker) {
                marker.addListener('click', function() {
                    map.panTo(obj);
                    infoWindow.setContent(name);
                    infoWindow.open(map, marker);

                });
            }

            setMarkerContent(obj, name, marker);

            markers.push([sID, obj, marker]);

        }

    });


};

function loadProducts(type, sID = 0) {// NOTE: sID is currently used for removing product

    var method;
    if (type == 1) {
        method = "showHomeDeliveryProducts";
    } else {
        method = "showWalkinProducts";
    }

    postStatic("views", "CheckoutView", method, null, function(data) {

        $("#left_top").html(data);

        // Update checkout details when qty is changed
        $(".qty").on("input", function() {

            var x = $(this);
            var qty = x.val();
            var pID = x.attr("data-pID");
            var sID = x.attr("data-sID");
            var uID = x.attr("data-uID");
            var price = x.attr("data-price");


            var json = getJsonString(
                {uID: uID},
                {pID: pID},
                {sID: sID},
                {qty: qty},
                {price: price}
            );

            postStatic("controllers", "UserController", "updateQty", json, function(data) {
                loadCheckoutDetails();
            });

        });

        // get details
        loadCheckoutDetails();

        // shop name hover
        $(".shop_name").mouseover(function() {

            var loc_x = $(this).attr("data-loc_x");
            var loc_y = $(this).attr("data-loc_y");

            loc_x = roundFix(loc_x, precision);
            loc_y = roundFix(loc_y, precision);

            var myLatLng = {lat: loc_x, lng: loc_y};
            map.panTo(myLatLng);

        });

        if (sID != 0) {
            for (var i = 0; i < markers.length; i++) {

                if (markers[i][0] == sID) {
                    var removeMarker = true;

                    $(".shop_name").each(function() {

                        var rmLoc = roundFix($(this).attr("data-loc_x"), precision);
                        if (rmLoc == markers[i][1].lat) {
                            removeMarker = false;
                        }

                    });

                    if (removeMarker) {
                        markers[i][2].setMap(null);
                        markers = removeFromArray(markers[i], markers);
                        break;
                    }
                }

            }
        }

    });

}

function loadCheckoutDetails() {
    postStatic("views", "CheckoutView", "showCartDetails", type, function(data) {
        $("#right_section").html(data);
    });
}

function gotoConfirmation() {
    $(location).attr("href", "confirmation.php?type=" + type)
}

function removeFromCart(pID, sID, uID) {

    var json = getJsonString(
        {uID: uID},
        {pID: pID},
        {sID: sID}
    );

    console.info("remove from cart: " + json);

    postStatic("controllers", "UserController", "removeFromCart", json, function(data) {
        loadProducts(type, sID);
        // loadCheckoutDetails();
        countCart(uID);

    });

}