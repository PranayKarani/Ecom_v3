/**
 * Created by PranayKarani on 24/06/2016.
 */
function onWishListClick(id) {

    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "controllers",
            class: "UserController",
            method: "addToWishlist",
            params: id
        },
        function(data) {
            data = parseInt(data);
            if (data < 0) {
                $("#login_modal").slideDown();
            } else {
                $("#header_wishlist_button").text("Wishlist: " + data);
            }
        }
    );

}

function openProductInfo(id) {

    // TODO make it post instead of get
    window.location.href = "productInfo.php?id=" + id;

}