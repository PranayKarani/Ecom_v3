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