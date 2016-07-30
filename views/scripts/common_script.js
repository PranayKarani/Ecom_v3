/**
 * Created by PranayKarani on 24/06/2016.
 */

/** Wishlist Stuff */
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
                x.attr('title', 'remove from wishlist');
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
            x.attr('title', 'add to wishlist');
        }

    });


}

function toggleThumbnail(x) {// x = this element


    var inWL = x.getAttribute('data-in');
    var id = x.getAttribute('data-id');

    x = $(".wishlist_thumbnail[name~=" + id + "]");
    if (inWL == 1) {

        removeFromWishlist(id, x);

    } else {

        addToWishlist(id, x);

    }


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

function showLoginModal() {
    $("#login_modal").slideDown();
}

function openCategoryPage(x) {
    var name = x.getAttribute('id');
    var url = "category.php?category=" + name;
    //window.location.href = "category.php?category=" + name;
    $(location).attr('href', url);
}

function resetFilterPrice() {
    var min = $("#min_price");
    var max = $("#max_price");
    var min_price = min.attr("data-price");
    var max_price = max.attr("data-price");

    min.val(min_price);
    max.val(max_price);

}

/** Other */

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

function goBack() {
    window.History.back();
}

function roundFix(number, precision) {
    var multi = Math.pow(10, precision);
    return Math.round((number * multi).toFixed(precision + 1)) / multi;
}

function removeFromArray(element, array) {

    var idx = array.indexOf(element);
    if (idx > -1) {

        array.slice(idx, 1);

    }

    return array;

}