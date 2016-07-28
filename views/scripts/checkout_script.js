/**
 * Created by PranayKarani on 26/07/2016.
 */
var type;

$(document).ready(function() {

    type = $("#type").val();
    loadProducts(type);


});

function loadProducts(type) {

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

            console.info("remove from cart: " + json);

            postStatic("controllers", "userController", "updateQty", json, function(data) {
                loadCheckoutDetails();
            });

        });

        // get details
        loadCheckoutDetails();

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