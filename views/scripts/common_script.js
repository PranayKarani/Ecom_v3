/**
 * Created by PranayKarani on 24/06/2016.
 */
function onWishListClick(id) {
    alert("Wishlist Coming Soon :)\nProductID: " + id)
}

function openProductInfo(id) {

    // TODO make it post instead of get
    window.location.href = "productInfo.php?id=" + id;

}