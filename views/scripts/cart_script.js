/**
 * Created by PranayKarani on 07/07/2016.
 */
$(document).ready(function() {

    loadCart();

});

function removeFromCart(pID, sID, uID) {

    var json = getJsonString(
        {uID: uID},
        {pID: pID},
        {sID: sID}
    );

    console.info("remove from cart: " + json);

    postStatic("controllers", "userController", "removeFromCart", json, function(data) {
        loadCart();
        countCart(uID);
    });

}

function loadCart() {

    postStatic("views", "CartView", "showCartProducts", null, function(data) {

        $("#left_section").html(data);

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
                loadCartDetails();
            });

        });

        // get details
        loadCartDetails();

    });

}

function loadCartDetails() {
    // get details
    postStatic("views", "CartView", "showCartDetails", null, function(data) {
        $("#right_section").html(data);
    });
}
