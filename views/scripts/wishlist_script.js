/**
 * Created by PranayKarani on 01/07/2016.
 */
var uID = -1;
$(document).ready(function() {

    uID = $("#uID").val();

    loadWishlist();

});

function loadWishlist() {
    postStatic("views", "WishlistView", "showWishlistProducts", uID, function(data) {
        $("#wishlist_products").html(data);
    });
    // count wishlist
    countWishlist(uID);
}

function removeFromWishlist(id) {

    var arr = [];
    arr.push({uID: uID});
    arr.push({pID: id});

    var json = JSON.stringify(arr);
    postStatic("controllers", "UserController", "removeFromWishlist", json, function(data) {
        console.info("remove from wishlist: " + data);
        loadWishlist();
    });


}