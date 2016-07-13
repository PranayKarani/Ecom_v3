/**
 * Created by PranayKarani on 01/07/2016.
 */
var uID = -1;
$(document).ready(function() {

    uID = $("#uID").val();

    loadWishlist();

});

function loadWishlist() {
    // count wishlist and load page controls
    postStatic("controllers", "UserController", "countWishlist", uID, function(data) {
        data = parseInt(data);
        if (data > 0) {

            // Count
            $("#header_wishlist_button").text("Wishlist: " + data);
            wishlist_count = data;

            // Page Controls
            postStatic("views", "WishlistView", "getPageControls", wishlist_count, function(data) {
                var pg_no = 0;
                $("#page_controls").html(data);

                // get no of pages
                var page_no_buttons = $(".page_no_buttons");
                var page_count = page_no_buttons.length;

                $(".page_no_buttons:nth-child(" + (pg_no + 2) + ")").prop('disabled', true);

                disableButtons(pg_no);

                // if page_no is clicked
                page_no_buttons.click(function() {
                    pg_no = $(this).attr('id');
                    page_no_buttons.prop('disabled', false);
                    $(this).prop('disabled', true);
                    loadWishlistProducts(pg_no);
                    disableButtons(pg_no);
                });

                $("#prev_page").click(function() {
                    pg_no--;
                    page_no_buttons.prop('disabled', false);
                    $(".page_no_buttons:nth-child(" + (pg_no + 2) + ")").prop('disabled', true);
                    loadWishlistProducts(pg_no);
                    disableButtons(pg_no);
                });
                $("#next_page").click(function() {
                    pg_no++;
                    page_no_buttons.prop('disabled', false);
                    $(".page_no_buttons:nth-child(" + (pg_no + 2) + ")").prop('disabled', true);
                    loadWishlistProducts(pg_no);
                    disableButtons(pg_no);
                });

                function disableButtons(pg_no) {
                    if (page_count > 1) {
                        var last = page_count - 1;
                        if (pg_no == 0) {
                            $("#prev_page").prop('disabled', true);
                            $("#next_page").prop('disabled', false);
                        } else if (pg_no > 0 && pg_no < last) {
                            $("#prev_page").prop('disabled', false);
                            $("#next_page").prop('disabled', false);
                        } else if (pg_no == last) {
                            $("#prev_page").prop('disabled', false);
                            $("#next_page").prop('disabled', true);
                        }
                    }
                }

            });
        } else {
            $("#header_wishlist_button").text("Wishlist");
            wishlist_count = 0;
        }
    });


    loadWishlistProducts(0);
}

function loadWishlistProducts(pg_no) {

    postStatic("views", "WishlistView", "showWishlistProducts", pg_no, function(data) {
        $("#wishlist_products").html(data);
        $(".product_link").click(function() {
            var id = $(this).attr('id');
            openProductInfo(id);
        });
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
    });
}