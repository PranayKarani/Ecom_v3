/**
 * Created by PranayKarani on 24/06/2016.
 */
function addToWishlist(id, x) {

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
                x.attr('src', 'res/images/extra/cross.png');
                x.attr('data-in', 1);
            }
        }
    );

}

function removeFromWishlist(id, x) {

    postStatic("controllers", "UserController", "removeFromWishlist", id, function(data) {

        if (typeof loadWishlist == 'function') {
            loadWishlist();
        } else {
            $("#header_wishlist_button").text("Wishlist: " + data);
            x.attr('src', 'res/images/extra/heart.png');
            x.attr('data-in', 0);
        }

    });


}

function openProductInfo(id) {

    // TODO make it post instead of get
    window.location.href = "productInfo.php?id=" + id;

}

function openShopPage(sID, category) {

    var cat = category || 0;

    var url;
    if (cat != 0) {
        url = "shop.php?category=" + category + "&id=" + sID;
    } else {
        url = "shop.php?id=" + sID;
    }
    $(location).attr('href', url);

}

function postStatic(dir, Class, method, params, func) {

    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: dir,
            class: Class,
            method: method,
            params: params
        },
        func
    )

}

function getJsonString(...obj) {

    var arr = [];

    for (var i = 0; i < obj.length; i++) {
        arr.push(obj[i]);
    }

    return JSON.stringify(arr);

}

function wishlistThumbnailLoader() {

    $(".wishlist_thumbnail").click(function() {

        var x = $(this);
        var inWL = x.attr('data-in');
        var id = x.attr('data-id');

        x = $(".wishlist_thumbnail[name~=" + id + "]");
        if (inWL == 1) {

            removeFromWishlist(id, x);

        } else {

            addToWishlist(id, x);

        }

    });

}

$(document).ready(function() {

    wishlistThumbnailLoader();

});