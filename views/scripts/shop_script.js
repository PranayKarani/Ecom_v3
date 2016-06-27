/**
 * Created by PranayKarani on 13/06/2016.
 */
$(document).ready(function () {

    $(".product_link").click(function () {
        var id = $(this).attr('id');
        openProductInfo(id);
    });

    $(".shop_list").click(function () {

        var id = $(this).attr('id');
        var category = $(".data").attr('id');

        var url;
        if (category == null || category == "") {
            url = "shop.php?id=" + id;
        } else {
            url = "shop.php?category=" + category + "&id=" + id;
        }

        $(location).attr('href', url);

    });

});
