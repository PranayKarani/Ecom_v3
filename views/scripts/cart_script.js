/**
 * Created by PranayKarani on 07/07/2016.
 */
$(document).ready(function() {

    loadHomeDelProductsInCart();
    loadNonHomeDelProductsInCart();

});

function removeFromCart(pID, sID, uID) {

    var json = getJsonString(
        {uID: uID},
        {pID: pID},
        {sID: sID}
    );

    console.info("remove from cart: " + json);

    postStatic("controllers", "userController", "removeFromCart", json, function(data) {
        loadHomeDelProductsInCart();
        loadNonHomeDelProductsInCart();
        countCart(uID);
    });

}

function loadHomeDelProductsInCart() {

    postStatic("views", "CartView", "showHomeDeliveryProducts", null, function(data) {

        $("#top_section").html(data);

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


    });

}

function loadNonHomeDelProductsInCart() {

    postStatic("views", "CartView", "showWalkinProducts", null, function(data) {

        $("#bottom_section").html(data);

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

    });

}


function homeDelivery_checkOut() {
    $(location).attr("href", "checkOut.php?type=1")
}
function walkin_checkOut() {
    $(location).attr("href", "checkOut.php?type=0")
}
